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

        $this->loadViewsFrom(__DIR__ . '/views/mails', 'ProductMails');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->mergeConfigFrom(__DIR__.'/../config/product.php', 'products');
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $models = collect(config('products'));

        $models->each(function($item){
            $this->app->singleton($item['class'], function () use ($item) {
                $object = new $item['class']();
                $object->setModelId($item['id']);
                return $object;
            });
        });
    }
}
?>