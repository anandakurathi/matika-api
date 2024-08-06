<?php

namespace App\Providers;

use App\Events\PasswordResetCode;
use App\Listeners\PasswordResetCodeEmail;
use App\Listeners\SendPasswordResetEmail;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PasswordReset::class => [
            SendPasswordResetEmail::class,
        ],
        PasswordResetCode::class => [
            PasswordResetCodeEmail::class,
        ]
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
