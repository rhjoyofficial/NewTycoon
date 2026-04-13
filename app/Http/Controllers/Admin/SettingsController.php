<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }
    /**
     * Display main settings dashboard
     */
    public function index()
    {
        return view('admin.settings.index');
    }

    /**
     * Display general settings
     */
    public function general()
    {
        $settings = [
            'site_name' => config('app.name', 'Laravel Shop'),
            'site_email' => config('mail.from.address', 'noreply@example.com'),
            'site_phone' => config('settings.site_phone', '+1 (555) 123-4567'),
            'site_address' => config('settings.site_address', '123 Main St, City, Country'),
            'site_currency' => config('settings.site_currency', 'USD'),
            'timezone' => config('app.timezone', 'UTC'),
            'date_format' => config('settings.date_format', 'Y-m-d'),
            'time_format' => config('settings.time_format', 'H:i:s'),
            'pagination_limit' => config('settings.pagination_limit', 20),
        ];

        $timezones = \DateTimeZone::listIdentifiers();
        $currencies = [
            'USD' => 'US Dollar ($)',
            'EUR' => 'Euro (€)',
            'GBP' => 'British Pound (£)',
            'JPY' => 'Japanese Yen (¥)',
            'CAD' => 'Canadian Dollar (C$)',
            'AUD' => 'Australian Dollar (A$)',
        ];

        return view('admin.settings.general', compact('settings', 'timezones', 'currencies'));
    }

    /**
     * Update general settings
     */
    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'site_phone' => 'nullable|string|max:50',
            'site_address' => 'nullable|string|max:500',
            'site_currency' => 'required|string|size:3',
            'timezone' => 'required|string|max:100',
            'date_format' => 'required|string|max:20',
            'time_format' => 'required|string|max:20',
            'pagination_limit' => 'required|integer|min:5|max:100',
        ]);

        // Update config values (in real application, save to database)
        foreach ($validated as $key => $value) {
            if ($key === 'site_name') {
                config(['app.name' => $value]);
            } elseif ($key === 'site_email') {
                config(['mail.from.address' => $value]);
            } else {
                config(["settings.{$key}" => $value]);
            }
        }

        // Clear cache
        Cache::forget('app_settings');

        return redirect()->route('admin.settings.general')
            ->with('success', 'General settings updated successfully.');
    }

    /**
     * Display store settings
     */
    public function store()
    {
        $settings = [
            'store_status' => config('settings.store_status', 'open'),
            'maintenance_mode' => config('settings.maintenance_mode', false),
            'allow_registration' => config('settings.allow_registration', true),
            'require_email_verification' => config('settings.require_email_verification', true),
            'allow_guest_checkout' => config('settings.allow_guest_checkout', true),
            'minimum_order_amount' => config('settings.minimum_order_amount', 0),
            'tax_enabled' => config('settings.tax_enabled', true),
            'tax_rate' => config('settings.tax_rate', 10),
            'tax_inclusive' => config('settings.tax_inclusive', false),
            'currency_symbol' => config('settings.currency_symbol', '$'),
            'currency_position' => config('settings.currency_position', 'left'),
            'decimal_places' => config('settings.decimal_places', 2),
        ];

        return view('admin.settings.store', compact('settings'));
    }

    /**
     * Update store settings
     */
    public function updateStore(Request $request)
    {
        $validated = $request->validate([
            'store_status' => 'required|in:open,closed',
            'maintenance_mode' => 'boolean',
            'allow_registration' => 'boolean',
            'require_email_verification' => 'boolean',
            'allow_guest_checkout' => 'boolean',
            'minimum_order_amount' => 'numeric|min:0',
            'tax_enabled' => 'boolean',
            'tax_rate' => 'numeric|min:0|max:100',
            'tax_inclusive' => 'boolean',
            'currency_symbol' => 'required|string|max:10',
            'currency_position' => 'required|in:left,right,left_space,right_space',
            'decimal_places' => 'required|integer|min:0|max:4',
        ]);

        foreach ($validated as $key => $value) {
            config(["settings.{$key}" => $value]);
        }

        Cache::forget('store_settings');

        return redirect()->route('admin.settings.store')
            ->with('success', 'Store settings updated successfully.');
    }

    /**
     * Display email settings
     */
    public function email()
    {
        $settings = [
            'mail_mailer' => config('mail.default', 'smtp'),
            'mail_host' => config('mail.mailers.smtp.host', 'smtp.mailgun.org'),
            'mail_port' => config('mail.mailers.smtp.port', 587),
            'mail_username' => config('mail.mailers.smtp.username'),
            'mail_password' => config('mail.mailers.smtp.password'),
            'mail_encryption' => config('mail.mailers.smtp.encryption', 'tls'),
            'mail_from_address' => config('mail.from.address', 'hello@example.com'),
            'mail_from_name' => config('mail.from.name', 'Example'),
            'mail_reply_to' => config('mail.reply_to.address', 'noreply@example.com'),
        ];

        $mailers = [
            'smtp' => 'SMTP',
            'sendmail' => 'Sendmail',
            'mailgun' => 'Mailgun',
            'ses' => 'Amazon SES',
            'postmark' => 'Postmark',
            'log' => 'Log',
            'array' => 'Array',
        ];

        return view('admin.settings.email', compact('settings', 'mailers'));
    }

    /**
     * Update email settings
     */
    public function updateEmail(Request $request)
    {
        $validated = $request->validate([
            'mail_mailer' => 'required|string|max:50',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|integer|min:1|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|string|max:10',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
            'mail_reply_to' => 'nullable|email|max:255',
        ]);

        // Update .env file (in real app, use database or config file)
        $envUpdates = [
            'MAIL_MAILER' => $validated['mail_mailer'],
            'MAIL_HOST' => $validated['mail_host'],
            'MAIL_PORT' => $validated['mail_port'],
            'MAIL_USERNAME' => $validated['mail_username'],
            'MAIL_PASSWORD' => $validated['mail_password'],
            'MAIL_ENCRYPTION' => $validated['mail_encryption'],
            'MAIL_FROM_ADDRESS' => $validated['mail_from_address'],
            'MAIL_FROM_NAME' => $validated['mail_from_name'],
        ];

        Cache::forget('email_settings');

        return redirect()->route('admin.settings.email')
            ->with('success', 'Email settings updated successfully.');
    }

    /**
     * Display roles management page
     */
    public function roles()
    {
        $roles = Role::withCount('users', 'permissions')->paginate(20);
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('_', $permission->name)[0] ?? 'other';
        });

        return view('admin.settings.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Show create role form
     */
    public function createRole()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('_', $permission->name)[0] ?? 'other';
        });

        return view('admin.settings.roles.create', compact('permissions'));
    }

    /**
     * Store a new role
     */
    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        DB::beginTransaction();

        try {
            $role = Role::create([
                'name' => Str::slug($validated['name']),
                'slug' => Str::slug($validated['name']),
                'display_name' => $validated['display_name'],
                'description' => $validated['description'],
            ]);

            if (!empty($validated['permissions'])) {
                $role->permissions()->sync($validated['permissions']);
            }

            DB::commit();

            return redirect()->route('admin.settings.roles.index')
                ->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create role: ' . $e->getMessage());
        }
    }

    /**
     * Show edit role form
     */
    public function editRole(Role $role)
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('_', $permission->name)[0] ?? 'other';
        });

        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.settings.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update role
     */
    public function updateRole(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            $role->update([
                'name' => Str::slug($validated['name']),
                'slug' => Str::slug($validated['name']),
                'display_name' => $validated['display_name'],
                'description' => $validated['description'],
            ]);

            DB::commit();

            return redirect()->route('admin.settings.roles.index')
                ->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update role: ' . $e->getMessage());
        }
    }

    /**
     * Delete role
     */
    public function destroyRole(Role $role)
    {
        // Prevent deletion of essential roles
        $protectedRoles = ['admin', 'customer'];
        if (in_array($role->name, $protectedRoles)) {
            return redirect()->route('admin.settings.roles.index')
                ->with('error', 'Cannot delete protected role: ' . $role->name);
        }

        DB::beginTransaction();

        try {
            // Remove role from users
            $role->users()->detach();

            // Remove permissions
            $role->permissions()->detach();

            // Delete role
            $role->delete();

            DB::commit();

            return redirect()->route('admin.settings.roles.index')
                ->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.settings.roles.index')
                ->with('error', 'Failed to delete role: ' . $e->getMessage());
        }
    }

    /**
     * Sync permissions to role
     */
    public function syncPermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        try {
            $role->permissions()->sync($request->permissions ?? []);

            return response()->json([
                'success' => true,
                'message' => 'Permissions updated successfully.',
                'data' => [
                    'role' => $role->load('permissions'),
                    'permission_count' => $role->permissions()->count()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display permissions management page
     */
    public function permissions()
    {
        $permissions = Permission::withCount('roles')
            ->orderBy('name')
            ->paginate(20);

        $permissionGroups = Permission::all()->groupBy(function ($permission) {
            return explode('_', $permission->name)[0] ?? 'other';
        });

        return view('admin.settings.permissions.index', compact('permissions', 'permissionGroups'));
    }

    /**
     * Store a new permission
     */
    public function storePermission(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'group' => 'nullable|string|max:100',
        ]);

        try {
            $permission = Permission::create([
                'name' => $validated['name'],
                'display_name' => $validated['display_name'],
                'description' => $validated['description'],
            ]);

            return redirect()->route('admin.settings.permissions.index')
                ->with('success', 'Permission created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create permission: ' . $e->getMessage());
        }
    }

    /**
     * Update permission
     */
    public function updatePermission(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            $permission->update($validated);

            return redirect()->route('admin.settings.permissions.index')
                ->with('success', 'Permission updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update permission: ' . $e->getMessage());
        }
    }

    /**
     * Delete permission
     */
    public function destroyPermission(Permission $permission)
    {
        try {
            // Remove permission from roles
            $permission->roles()->detach();

            // Delete permission
            $permission->delete();

            return redirect()->route('admin.settings.permissions.index')
                ->with('success', 'Permission deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.permissions.index')
                ->with('error', 'Failed to delete permission: ' . $e->getMessage());
        }
    }

    /**
     * Display maintenance page
     */
    public function maintenance()
    {
        $systemInfo = [
            'laravel_version' => app()->version(),
            'php_version' => phpversion(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
            'server_os' => php_uname(),
            'database_driver' => config('database.default'),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'timezone' => config('app.timezone'),
            'debug_mode' => config('app.debug') ? 'Enabled' : 'Disabled',
            'environment' => app()->environment(),
            'app_url' => config('app.url'),
        ];

        $storageInfo = [
            'total' => disk_total_space(base_path()),
            'free' => disk_free_space(base_path()),
            'used' => disk_total_space(base_path()) - disk_free_space(base_path()),
        ];

        // Convert bytes to readable format
        foreach ($storageInfo as $key => $bytes) {
            $storageInfo[$key . '_formatted'] = $this->formatBytes($bytes);
        }

        return view('admin.settings.maintenance', compact('systemInfo', 'storageInfo'));
    }

    /**
     * Clear application cache
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            return redirect()->route('admin.settings.maintenance')
                ->with('success', 'Application cache cleared successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.maintenance')
                ->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }

    /**
     * Clear view cache
     */
    public function clearView()
    {
        try {
            Artisan::call('view:clear');

            return redirect()->route('admin.settings.maintenance')
                ->with('success', 'View cache cleared successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.maintenance')
                ->with('error', 'Failed to clear view cache: ' . $e->getMessage());
        }
    }

    /**
     * Create database backup
     */
    public function createBackup()
    {
        try {
            Artisan::call('backup:run');

            $output = Artisan::output();

            return redirect()->route('admin.settings.maintenance')
                ->with('success', 'Database backup created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.maintenance')
                ->with('error', 'Failed to create backup: ' . $e->getMessage());
        }
    }

    /**
     * Optimize application
     */
    public function optimize()
    {
        try {
            Artisan::call('optimize:clear');
            Artisan::call('optimize');

            return redirect()->route('admin.settings.maintenance')
                ->with('success', 'Application optimized successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.maintenance')
                ->with('error', 'Failed to optimize application: ' . $e->getMessage());
        }
    }

    /**
     * Helper method to format bytes
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
    /**
     * Get permission data for AJAX
     */
    public function getPermission(Permission $permission)
    {
        return response()->json($permission);
    }
}
