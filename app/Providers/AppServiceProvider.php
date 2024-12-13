<?php

namespace App\Providers;

use App\Repositories\Part\PartEloquentRepository;
use App\Repositories\Part\PartRepository;
use App\Repositories\Product\ProductEloquentRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Variant\VariantEloquentRepository;
use App\Repositories\Variant\VariantRepository;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepository::class, ProductEloquentRepository::class);
        $this->app->bind(PartRepository::class, PartEloquentRepository::class);
        $this->app->bind(VariantRepository::class, VariantEloquentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
