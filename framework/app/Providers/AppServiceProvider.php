<?php

namespace Framework\Providers;

use Illuminate\Support\ServiceProvider;

use Framework\Adapters\Feed\Services\BuscadorDeFeedsService\FeedIoAdapter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FeedIoAdapter::class, function ($app) {
            return new FeedIoAdapter(
                $app->make(\FeedIo\FeedIo::class)
            );

            // return new FeedIoAdapter(
            //     \FeedIo\Factory::create()->getFeedIo()
            // );
        });

        $this->app->bind(\FeedIo\FeedIo::class, function ($app) {

            // Isso foi necessario pra contornar o problema com discover
            $factory = new \FeedIo\Factory();

            $loggerConfig = [
                'builder' => 'NullLogger',
                'config' => [],
            ];

            $clientConfig = [
                'builder' => 'GuzzleClient',
                'config' => [],
            ];

            return new \Framework\FeedIo\FeedIo(
                $factory->getBuilder(
                    $clientConfig['builder'],
                    $factory->extractConfig($clientConfig)
                )->getClient(),
                $factory->getBuilder(
                    $loggerConfig['builder'],
                    $factory->extractConfig($loggerConfig)
                )->getLogger()
            );
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
