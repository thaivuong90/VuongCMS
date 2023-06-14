<?php

namespace VuongCMS\Common;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use VuongCMS\Common\Middlewares\SystemAuth;

class CommonServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // php artisan vendor:publish --tag=common.lang --force
        $this->publishes([
            __DIR__.'/Lang' => resource_path('lang'),
        ], 'common.lang');

        // php artisan vendor:publish --tag=common.assets --force
        $this->publishes([
            __DIR__.'/Assets' => public_path('common'),
        ], 'common.assets');

        $this->loadMigrationsFrom(__DIR__ . '/Migrations', 'system');

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('system.auth', SystemAuth::class);
    }
}
