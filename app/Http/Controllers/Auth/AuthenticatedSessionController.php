<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Capture the guest session ID BEFORE regeneration.
        // session()->regenerate() below will assign a new ID, making the
        // old guest cart unreachable if we don't save this first.
        $guestSessionId = $request->session()->getId();

        $request->authenticate();

        $request->session()->regenerate();

        // Merge any guest cart items into the now-authenticated user's cart
        // using the OLD session ID captured before regeneration.
        Cart::mergeGuestCart($guestSessionId);

        flash('Login successful', 'success');

        $user = Auth::user();

        if ($user->hasAnyRole(['admin', 'moderator'])) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('home'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        flash('Logout successfully', 'success');

        return redirect('/');
    }
}
