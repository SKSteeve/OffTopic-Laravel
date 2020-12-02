<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('create-post', function ($user) {
            return $user->hasRoles(['admin', 'author']);
        });

        Gate::define('delete-post', function ($user) {
            return $user->hasRoles(['admin', 'author']);
        });

        Gate::define('edit-post', function ($user) {
            return $user->hasRoles(['admin', 'author']);
        });

        Gate::define('delete-edit-comments', function($user) {
            return $user->hasRole('admin');
        });

        Gate::define('edit-user-profile', function ($user) {
            return $user->hasRole('admin');
        });
    }
}
