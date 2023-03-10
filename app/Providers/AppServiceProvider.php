<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Pagination\Paginator;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        Blade::directive('convertCurrency', function ($value) {
            return "Rp. <?php echo number_format($value, 0, '.', '.'); ?>";
        });

        Filament::serving(function () {
            Filament::registerUserMenuItems([
                'logout' => UserMenuItem::make()
                    ->label(trans('Logout'))
                    ->url(route('logout'))
            ]);
        });
    }
}
