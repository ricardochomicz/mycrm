<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('isSuperAdmin', function (User $user) {
            if (in_array(1, $user->roles->pluck('id')->toArray())) //super admin
                return true;
        });

        Gate::define('isAdmin', function (User $user) {
            if (in_array(2, $user->roles->pluck('id')->toArray())) //super admin
                return true;
        });

        Gate::before(function (User $user) {
            if (in_array(1, $user->roles->pluck('id')->toArray())) //super admin
                return true;
        });

    }
}
