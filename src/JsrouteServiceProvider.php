<?php

namespace Nonetallt\Jsroute;

use Illuminate\Support\ServiceProvider;

class JsrouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish configuration file
        $this->publishes([
            __DIR__.'/config/jsroute.php' => config_path('jsroute.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Merge settings 1 level deep in the array
        $this->mergeConfigFrom(
            __DIR__.'/config/jsroute.php', 'jsroute'

        );

        // Register the publish command
        if ($this->app->runningInConsole()) {
            $this->commands([
                PublishRoutesCommand::class
            ]);
        }
    }
}
