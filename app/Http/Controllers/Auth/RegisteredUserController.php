<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Throwable;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration.
     */

    public function store(Request $request): RedirectResponse
    {
        // 1. Validation (Keep outside transaction)
        try {
            $request->validate([
                'name' => ['required',  'string',  'max:255',  'regex:/^[a-zA-Z\s]+$/'],
                'email' => ['required',  'string',  'lowercase',  'email:rfc,dns',  'max:255',  'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
        } catch (Throwable $e) {
            Log::error('Registration validation failed', ['error' => $e->getMessage()]);
            throw $e;
        }

        // Start the Transaction
        DB::beginTransaction();

        try {
            // 2. Create User & Auto-Verify
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->markEmailAsVerified();

            // 3. Assign Role
            $user->assignRole('customer');

            // 4. Create Profile
            $user->profile()->create([]);

            // If we reach here, everything worked!
            DB::commit();

            Auth::login($user);

            // Custom flash message: flash(message, action, time)
            flash('Welcome! Your account has been created successfully.', 'success', 2000);

            return redirect()->route('home');
        } catch (Throwable $e) {
            // Something went wrong, undo everything in the DB
            DB::rollBack();

            Log::error('Registration failed at some point', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            flash('Registration failed. Please try again.', 'error', 5000);

            return redirect()->back()->withInput();
        }
    }
}
