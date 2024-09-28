<?php
namespace Harrison\LaravelProduct\Providers;

use Illuminate\Support\ServiceProvider;

class HarrisonLaravelProductProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->loadViewsFrom(__DIR__ . '/../views/mails', 'ProductMails');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->mergeConfigFrom(__DIR__.'/../config/product.php', 'products');
        $this->mergeConfigFrom(
            __DIR__.'/../config/database.php', 'database.connections.harrison_laravel_product'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
