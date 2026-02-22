<?php

namespace VichOne\ThaiAddress;

use Illuminate\Support\ServiceProvider;
use VichOne\ThaiAddress\Commands\InstallThaiAddresses;
use VichOne\ThaiAddress\Commands\SyncThaiAddresses;

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
