<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function dashboard()
    {
        // Only admins can reach here
        return view('admin.dashboard');
    }

    public function manageUsers()
    {
        // Additional permission check
        if (!auth()->user()->hasPermission('manage_users')) {
            abort(403, 'You need manage_users permission');
        }

        return view('admin.users.index');
    }
}
