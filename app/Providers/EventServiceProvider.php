<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\LogSuccessfulLogout;
use App\Events\OrderProcessed;
use App\Listeners\NotifyOrderProcessed;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected $listen = [
        Login::class => [
            LogSuccessfulLogin::class,
        ],
        Logout::class => [
            LogSuccessfulLogout::class,
        ],
        OrderProcessed::class => [
            NotifyOrderProcessed::class,
        ]
        // Add more events and listeners here
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // parent::boot();
    }
}
