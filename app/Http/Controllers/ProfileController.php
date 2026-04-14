<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // ─────────────────────────────────────────────
    //  Dashboard
    // ─────────────────────────────────────────────

    public function dashboard(): View
    {
        $user = Auth::user();
        $user->loadMissing('profile');

        // Aggregate stats — single query each, no N+1.
        $userId = $user->id;
        $stats = [
            'total_orders' => Order::where('user_id', $userId)->count(),
            'total_spent'  => (float) Order::where('user_id', $userId)
                                ->where('payment_status', 'paid')
                                ->sum('total_amount'),
            'pending'      => Order::where('user_id', $userId)->where('status', 'pending')->count(),
            'completed'    => Order::where('user_id', $userId)->where('status', 'completed')->count(),
        ];

        // Five most-recent orders, items eager-loaded to avoid N+1 in the view.
        $recentOrders = Order::where('user_id', $userId)
            ->withCount('items')
            ->latest()
            ->limit(5)
            ->get();

        return view('customer.dashboard', compact('user', 'stats', 'recentOrders'));
    }

    // ─────────────────────────────────────────────
    //  Profile — show
    // ─────────────────────────────────────────────

    public function index(): View
    {
        return $this->profile();
    }

    public function profile(): View
    {
        $user = Auth::user();
        $user->loadMissing(['profile', 'addresses']);

        return view('customer.profile', compact('user'));
    }

    // ─────────────────────────────────────────────
    //  Profile — update core user fields
    // ─────────────────────────────────────────────

    /**
     * Update the authenticated user's name, email, and phone.
     * Email change clears verified_at so re-verification is required.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return back()->with('status', 'profile-updated');
    }

    // Alias kept for backward-compat with the POST /profile/update route.
    public function updateProfile(ProfileUpdateRequest $request): RedirectResponse
    {
        return $this->update($request);
    }

    // ─────────────────────────────────────────────
    //  Profile — update UserProfile extended fields
    // ─────────────────────────────────────────────

    /**
     * Update extended profile details stored in the user_profiles table.
     * These are deliberately separate from the core User record.
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date_of_birth' => ['nullable', 'date', 'before:today', 'after:1900-01-01'],
            'gender'        => ['nullable', 'in:male,female,other,prefer_not_to_say'],
            'bio'           => ['nullable', 'string', 'max:500'],
            'website'       => ['nullable', 'url', 'max:255'],
            'city'          => ['nullable', 'string', 'max:100'],
            'state'         => ['nullable', 'string', 'max:100'],
            'country'       => ['nullable', 'string', 'max:100'],
            'zip_code'      => ['nullable', 'string', 'max:20'],
        ]);

        // Create or update the profile row atomically.
        $request->user()->profile()->updateOrCreate(
            ['user_id' => $request->user()->id],
            $validated
        );

        return back()->with('status', 'settings-updated');
    }

    // ─────────────────────────────────────────────
    //  Addresses
    // ─────────────────────────────────────────────

    public function addresses(Request $request): RedirectResponse
    {
        // Profile page contains the address section; redirect with anchor.
        return redirect()->route('profile')->withFragment('addresses');
    }

    public function storeAddress(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type'           => 'required|in:shipping,billing',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:50',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city'           => 'required|string|max:100',
            'state'          => 'required|string|max:100',
            'postal_code'    => 'required|string|max:20',
            'country'        => 'required|string|max:100',
            'is_default'     => 'sometimes|boolean',
        ]);

        $request->user()->addresses()->create($validated);

        return back()->with('status', 'address-saved');
    }

    public function updateAddress(Request $request, Address $address): RedirectResponse
    {
        // Ownership check — prevent IDOR.
        abort_unless($address->user_id === Auth::id(), 404);

        $validated = $request->validate([
            'type'           => 'required|in:shipping,billing',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:50',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city'           => 'required|string|max:100',
            'state'          => 'required|string|max:100',
            'postal_code'    => 'required|string|max:20',
            'country'        => 'required|string|max:100',
            'is_default'     => 'sometimes|boolean',
        ]);

        $address->update($validated);

        return back()->with('status', 'address-updated');
    }

    public function deleteAddress(Address $address): RedirectResponse
    {
        // Ownership check — prevent IDOR.
        abort_unless($address->user_id === Auth::id(), 404);

        $address->delete();

        return back()->with('status', 'address-deleted');
    }

    // ─────────────────────────────────────────────
    //  Password
    // ─────────────────────────────────────────────

    public function updatePassword(Request $request): RedirectResponse
    {
        return $this->updateProfilePassword($request);
    }

    public function updateProfilePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->withPasswordStatus(__('Password updated successfully.'));
    }

    // ─────────────────────────────────────────────
    //  Orders (redirect shims)
    // ─────────────────────────────────────────────

    public function orders(): RedirectResponse
    {
        return redirect()->route('account.orders');
    }

    public function orderDetails(Order $order): RedirectResponse
    {
        // Ownership check before handing off to the orders.show route.
        abort_unless($order->user_id === Auth::id(), 404);

        return redirect()->route('orders.show', $order);
    }

    // ─────────────────────────────────────────────
    //  Misc
    // ─────────────────────────────────────────────

    public function settings(Request $request): View
    {
        return $this->profile();
    }

    public function downloads(): RedirectResponse
    {
        return back()->with('status', 'downloads-unavailable');
    }

    // ─────────────────────────────────────────────
    //  Account deletion
    // ─────────────────────────────────────────────

    public function deleteAccount(Request $request): RedirectResponse
    {
        return $this->destroy($request);
    }

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

        return redirect('/');
    }
}
