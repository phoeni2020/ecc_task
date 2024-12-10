<?php

namespace App\Providers;

use App\interfaces\PharmacyRepositoryInterface;
use App\interfaces\ProductRepositoryInterface;
use App\Repositories\PharmacyRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(PharmacyRepositoryInterface::class, PharmacyRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
