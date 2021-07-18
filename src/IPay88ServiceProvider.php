<?php

namespace IPay88;

use Illuminate\Support\ServiceProvider;

class IPay88ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'iPay88');

        $this->publishes([
            \dirname(__DIR__) . '/config/iPay88.php' => config_path('iPay88.php'),
        ], 'config');

        $this->publishes([
           \dirname(__DIR__).'/resources/views' => resource_path('views/vendor/iPay88'),
        ], 'views');

    }
}