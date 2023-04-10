<?php

namespace App\Providers;

use App\Enums\UserRoleEnum;
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
        Gate::define('isAdmin', function ($user) {
            return $user->role == UserRoleEnum::ADMIN;
        });

        Gate::define('isEditor', function ($user) {
            return $user->role == UserRoleEnum::EDITOR;
        });

        Gate::define('isAuthor', function ($user) {
            return $user->role == UserRoleEnum::AUTHOR;
        });
    }
}
