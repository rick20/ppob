<?php

namespace Rick20\PPOB;

use Illuminate\Support\ServiceProvider;

class PPOBServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ppob', function ($app) {
            return new PPOBManager($app);
        });
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ppob.php' => config_path('ppob.php')
        ], 'config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['ppob'];
    }
}
