<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\QuoteManager as QuoteManagerContract;
use App\Services\Quotes\QuoteManager;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            QuoteManagerContract::class,
            fn (Application $app) => new QuoteManager($app)
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
