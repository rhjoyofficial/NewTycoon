<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user()->load('profile');
        return view('admin.profile.index', compact('user'));
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = Auth::user();

        $user->update($request->only('name', 'email', 'phone'));

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only('bio', 'date_of_birth', 'gender', 'city', 'country')
        );

        flash('Profile updated successfully.', 'success');
        return back();
    }

    public function updateProfilePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'string', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        flash('Password changed successfully.', 'success');
        return back();
    }
}
