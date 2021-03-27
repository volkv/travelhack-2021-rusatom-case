<?php


namespace App\Services\ContentRelevantService;


use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class ContentRelevantServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ContentRelevantService::class, function () {
            return new ContentRelevantService(
                app(Client::class),
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
