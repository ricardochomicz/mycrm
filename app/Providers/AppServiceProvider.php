<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Tenant;
use App\Observers\ClientObserver;
use App\Observers\PlanObserver;
use App\Observers\ProductObserver;
use App\Observers\TenantObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Plan::observe(PlanObserver::class);
        Tenant::observe(TenantObserver::class);
        Client::observe(ClientObserver::class);
        Product::observe(ProductObserver::class);

        Livewire::setScriptRoute(function ($handle) {
            return Route::get('/vendor/livewire/livewire.js', $handle);
        });
    }
}
