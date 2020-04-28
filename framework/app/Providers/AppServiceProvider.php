<?php

namespace Framework\Providers;

use Illuminate\Support\ServiceProvider;

use Framework\Adapters\Feed\Services\BuscadorDeFeedsService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\FeedIo\FeedIo::class, function ($app) {
            return \FeedIo\Factory::create()->getFeedIo();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
