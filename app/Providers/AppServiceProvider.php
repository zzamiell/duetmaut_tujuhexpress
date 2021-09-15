<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        config([
            'client_be' => $this->client = new \GuzzleHttp\Client(
                ['base_uri' => env('IP_BE')]
            )
        ]);
    }
}
