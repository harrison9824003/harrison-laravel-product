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
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/views/mails', 'ProductMails');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes/product-api.php');
    }
}
?>