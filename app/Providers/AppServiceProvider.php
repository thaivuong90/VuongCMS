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
        // Register SystemServiceProvider
        $this->app->register(\VuongCMS\Api\Providers\ApiServiceProvider::class);
        $this->app->register(\VuongCMS\System\Providers\SystemServiceProvider::class);
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
