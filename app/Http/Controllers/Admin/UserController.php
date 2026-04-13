<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::with('roles')->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($role = $request->input('role')) {
            $query->whereHas('roles', fn($q) => $q->where('name', $role));
        }

        $users = $query->paginate(20)->withQueryString();
        $roles  = Role::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create(): View
    {
        $roles = Role::orderBy('name')->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-\'\.]+$/u'],
            'email'    => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{7,20}$/', 'unique:users,phone'],
            'password' => ['required', Password::defaults(), 'confirmed'],
            'status'   => ['required', 'in:active,inactive,deactivated'],
            'roles'    => ['nullable', 'array'],
            'roles.*'  => ['exists:roles,id'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'status'   => $validated['status'],
        ]);

        if (!empty($validated['roles'])) {
            $user->roles()->sync($validated['roles']);
        }

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} created successfully.");
    }

    public function show(User $user): View
    {
        $user->load(['roles', 'profile', 'addresses']);
        return view('admin.users.profile', compact('user'));
    }

    public function edit(User $user): View
    {
        $user->load('roles');
        $roles = Role::orderBy('name')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-\'\.]+$/u'],
            'email'    => ['required', 'string', 'email:rfc,dns', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'    => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{7,20}$/', Rule::unique('users', 'phone')->ignore($user->id)],
            'password' => ['nullable', Password::defaults(), 'confirmed'],
            'status'   => ['required', 'in:active,inactive,deactivated'],
            'roles'    => ['nullable', 'array'],
            'roles.*'  => ['exists:roles,id'],
        ]);

        $user->fill([
            'name'   => $validated['name'],
            'email'  => $validated['email'],
            'phone'  => $validated['phone'] ?? null,
            'status' => $validated['status'],
        ]);

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        $user->roles()->sync($validated['roles'] ?? []);

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} updated.");
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_if($user->id === Auth::id(), 403, 'You cannot delete your own account.');

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted.');
    }

    // ── Bulk actions ──────────────────────────────────────────────────────

    public function bulkDelete(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);
        User::whereIn('id', $ids)->where('id', '!=', Auth::id())->delete();

        return back()->with('success', 'Selected users deleted.');
    }

    public function bulkActivate(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);
        User::whereIn('id', $ids)->update(['status' => 'active']);

        return back()->with('success', 'Selected users activated.');
    }

    public function bulkDeactivate(Request $request): RedirectResponse
    {
        $ids = $request->input('ids', []);
        User::whereIn('id', $ids)->where('id', '!=', Auth::id())->update(['status' => 'deactivated']);

        return back()->with('success', 'Selected users deactivated.');
    }

    // ── Single status actions ─────────────────────────────────────────────

    public function activate(User $user): RedirectResponse
    {
        $user->update(['status' => 'active']);
        return back()->with('success', "{$user->name} activated.");
    }

    public function deactivate(User $user): RedirectResponse
    {
        abort_if($user->id === Auth::id(), 403, 'You cannot deactivate your own account.');

        $user->update(['status' => 'deactivated']);
        return back()->with('success', "{$user->name} deactivated.");
    }

    // ── Impersonation ─────────────────────────────────────────────────────

    public function impersonate(Request $request, User $user): RedirectResponse
    {
        abort_if($user->id === Auth::id(), 403, 'Cannot impersonate yourself.');

        // Store the original admin ID so we can switch back.
        $request->session()->put('impersonating_as', $user->id);
        $request->session()->put('impersonator_id', Auth::id());

        Auth::login($user);

        return redirect()->route('home')
            ->with('status', "You are now browsing as {$user->name}.");
    }
}
