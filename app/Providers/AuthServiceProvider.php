<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Policies\EditPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => EditPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
