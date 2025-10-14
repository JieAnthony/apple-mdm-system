<?php

namespace App\Providers;

use App\Services\DEP;
use App\Services\MDM;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton('dep', function ($app) {
            $depConfig = $app['config']->get('dep');

            return new DEP($depConfig['host'], $depConfig['username'], $depConfig['password'], $depConfig['name']);
        });

        $this->app->singleton('mdm', function ($app) {
            $mdmConfig = $app['config']->get('mdm');

            return new MDM($mdmConfig['host'], $mdmConfig['username'], $mdmConfig['password']);
        });
    }
}
