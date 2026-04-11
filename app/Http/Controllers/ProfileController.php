<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function dashboard(): RedirectResponse
    {
        return Redirect::route('account.orders');
    }

    public function index(): RedirectResponse
    {
        return Redirect::route('profile');
    }

    public function profile(Request $request): View
    {
        return $this->edit($request);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile')->with('status', 'profile-updated');
    }

    public function updateProfile(ProfileUpdateRequest $request): RedirectResponse
    {
        return $this->update($request);
    }

    public function orders(): RedirectResponse
    {
        return Redirect::route('account.orders');
    }

    public function orderDetails(Order $order): RedirectResponse
    {
        abort_unless($order->user_id === Auth::id(), 404);

        return Redirect::route('orders.show', $order);
    }

    public function addresses(Request $request): View
    {
        return $this->edit($request);
    }

    public function storeAddress(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:shipping,billing',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'is_default' => 'sometimes|boolean',
        ]);

        $request->user()->addresses()->create($validated);

        return Redirect::route('profile')->with('status', 'address-saved');
    }

    public function updateAddress(Request $request, Address $address): RedirectResponse
    {
        abort_unless($address->user_id === Auth::id(), 404);

        $validated = $request->validate([
            'type' => 'required|in:shipping,billing',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'is_default' => 'sometimes|boolean',
        ]);

        $address->update($validated);

        return Redirect::route('profile')->with('status', 'address-updated');
    }

    public function deleteAddress(Address $address): RedirectResponse
    {
        abort_unless($address->user_id === Auth::id(), 404);

        $address->delete();

        return Redirect::route('profile')->with('status', 'address-deleted');
    }

    public function settings(Request $request): View
    {
        return $this->edit($request);
    }

    public function updateSettings(ProfileUpdateRequest $request): RedirectResponse
    {
        return $this->update($request);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        return $this->updateProfilePassword($request);
    }

    public function updateProfilePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return Redirect::route('profile')->with('status', 'password-updated');
    }

    public function downloads(): RedirectResponse
    {
        return Redirect::route('profile')->with('status', 'downloads-unavailable');
    }

    public function deleteAccount(Request $request): RedirectResponse
    {
        return $this->destroy($request);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
