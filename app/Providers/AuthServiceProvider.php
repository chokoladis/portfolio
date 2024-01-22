<?php

namespace App\Providers;

use App\Models\Example_work;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\Workers;
use App\Policies\ExampleWorkPolicy;
use App\Policies\UserPolicy;
use App\Policies\WorkersPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Example_work::class => ExampleWorkPolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
