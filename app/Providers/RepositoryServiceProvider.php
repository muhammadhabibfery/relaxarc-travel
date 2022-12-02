<?php

namespace App\Providers;

use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Repositories\TravelGallery\TravelGalleryRepository;
use App\Repositories\TravelGallery\TravelGalleryRepositoryInterface;
use App\Repositories\TravelPackage\TravelPackageRepository;
use App\Repositories\TravelPackage\TravelPackageRepositoryInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{

    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        TravelPackageRepositoryInterface::class => TravelPackageRepository::class,
        TravelGalleryRepositoryInterface::class => TravelGalleryRepository::class,
        TransactionRepositoryInterface::class => TransactionRepository::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
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
            TravelPackageRepositoryInterface::class,
            TravelGalleryRepositoryInterface::class,
            TransactionRepositoryInterface::class
        ];
    }
}
