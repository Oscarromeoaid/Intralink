<?php

namespace App\Providers;

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
        \App\Models\Comment::class => \App\Policies\CommentPolicy::class,
        \App\Models\Post::class => \App\Policies\PostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Vous pouvez ajouter des Gates ici si nécessaire
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('moderator', function ($user) {
            return $user->role === 'moderator' || $user->role === 'admin';
        });
    }
}