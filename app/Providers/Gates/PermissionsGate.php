<?php

namespace App\Providers\Gates;

use Illuminate\Support\Facades\Gate;

class PermissionsGate
{
    public static function register()
    {
        Gate::define('access', function ($user, string $permission) {
            return $user->hasPermission($permission);
        });

        Gate::define('admin-area',function($user) {
            return $user->isAdmin() && $user->isActive() && $user->hasPermission('admin_area');
        });

    }
}