<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Midtrans\Notification;
use Midtrans\Snap;

class MidtransServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Snap::class, fn () => new Snap());
        $this->app->singleton(Notification::class, fn () => new Notification());
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Snap::class,
            Notification::class,
        ];
    }
}
