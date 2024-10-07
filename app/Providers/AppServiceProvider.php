<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Clients\ClientRepository;
use App\Repositories\Product\ProductRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind ClientRepository ao próprio ClientRepository
        $this->app->bind(ClientRepository::class, function ($app) {
            return new ClientRepository(); // Retorna uma nova instância de ClientRepository
        });

        // Bind ProductRepository ao próprio ProductRepository
        $this->app->bind(ProductRepository::class, function ($app) {
            return new ProductRepository(); // Retorna uma nova instância de ProductRepository
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
