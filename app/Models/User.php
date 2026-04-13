<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'status',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Get the user's profile.
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }
    /**
     * Get the user's addresses
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get the user's orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the user's transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the user's default shipping address
     */
    public function defaultShippingAddress()
    {
        return $this->hasOne(Address::class)
            ->where('type', 'shipping')
            ->where('is_default', true);
    }

    /**
     * Get the user's default billing address
     */
    public function defaultBillingAddress()
    {
        return $this->hasOne(Address::class)
            ->where('type', 'billing')
            ->where('is_default', true);
    }
    // Role & Permission Methods
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->firstOrFail();
        }

        return $this->roles()->syncWithoutDetaching([$role->id]);
    }

    public function assignRoles(array $roles)
    {
        $roleIds = [];
        foreach ($roles as $role) {
            if (is_string($role)) {
                $role = Role::where('name', $role)->firstOrFail();
            }
            $roleIds[] = $role->id;
        }

        return $this->roles()->syncWithoutDetaching($roleIds);
    }

    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->firstOrFail();
        }

        return $this->roles()->detach($role->id);
    }

    public function syncRoles(array $roles)
    {
        $roleIds = [];
        foreach ($roles as $role) {
            if (is_string($role)) {
                $role = Role::where('name', $role)->firstOrFail();
            }
            $roleIds[] = $role->id;
        }

        return $this->roles()->sync($roleIds);
    }

    public function hasRole($role)
    {
        // Eager load roles to avoid N+1 queries
        $this->loadMissing('roles');

        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        if (is_array($role)) {
            return $this->roles->whereIn('name', $role)->isNotEmpty();
        }

        return $this->roles->contains('id', $role->id);
    }

    public function hasAnyRole($roles): bool
    {
        // Eager load roles to avoid N+1 queries
        $this->loadMissing('roles');

        if (is_string($roles)) {
            // Handle pipe-separated string: 'admin|moderator'
            $roles = explode('|', $roles);
        }

        if (!is_array($roles)) {
            $roles = func_get_args();
        }

        return $this->roles->whereIn('name', $roles)->isNotEmpty();
    }

    public function hasAllRoles($roles)
    {
        if (is_string($roles)) {
            $roles = func_get_args();
        }

        $this->loadMissing('roles');
        $userRoles = $this->roles->pluck('name')->toArray();

        return count(array_diff($roles, $userRoles)) === 0;
    }

    public function hasPermission($permission)
    {
        $this->loadMissing('roles.permissions');
        return $this->roles->flatMap(function ($role) {
            return $role->permissions;
        })->contains('name', $permission);
    }

    public function hasPermissionThroughRole($permission)
    {
        $this->loadMissing('roles.permissions');
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    // Attribute accessors
    public function getRoleNamesAttribute()
    {
        $this->loadMissing('roles');
        return $this->roles->pluck('name');
    }

    public function getPermissionsAttribute()
    {
        $this->loadMissing('roles.permissions');
        return $this->roles->flatMap(function ($role) {
            return $role->permissions;
        })->unique('name');
    }

    // Scopes - FIXED: Use proper column names
    public function scopeRole($query, $role)
    {
        if (is_string($role)) {
            return $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role); // FIXED: Use 'name' not role_id
            });
        }

        if ($role instanceof Role) {
            return $query->whereHas('roles', function ($q) use ($role) {
                $q->where('id', $role->id); // FIXED: Use 'id' not role_id
            });
        }

        return $query;
    }

    public function scopeWhereRole($query, $roles)
    {
        $roles = is_array($roles) ? $roles : [$roles];

        return $query->whereHas('roles', function ($q) use ($roles) {
            $q->whereIn('name', $roles);
        });
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isModerator()
    {
        return $this->hasRole('moderator');
    }

    public function isCustomer()
    {
        return $this->hasRole('customer');
    }
}
