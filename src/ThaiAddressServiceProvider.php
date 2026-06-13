<?php

namespace Wichai\ThaiAddress;

use Illuminate\Support\ServiceProvider;
use Wichai\ThaiAddress\Commands\InstallThaiAddresses;
use Wichai\ThaiAddress\Commands\SyncThaiAddresses;

class ThaiAddressServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // $this->publishes([
        //     __DIR__ . '/../database/migrations/' => database_path('migrations'),
        // ], 'thai-address-migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                SyncThaiAddresses::class,
                InstallThaiAddresses::class,
            ]);
        }
    }

    public function register()
    {
        //
    }
}
