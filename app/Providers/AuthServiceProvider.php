<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('is_admin', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('is_caissier', function (User $user) {
            return $user->isCaissier();
        });

        Gate::define('is_gerant', function (User $user) {
            return $user->isGerant();
        });

        Gate::define('is_gerant_or_caissier', function (User $user) {
            return $user->isGerant() || $user->isCaissier();
        });

        Gate::define('is_all', function (User $user) {
            return $user->isGerant() || $user->isCaissier() || $user->isAdmin();
        });
    }
}
