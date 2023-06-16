<?php

namespace VuongCMS\System\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use VuongCMS\System\Http\Middlewares\CheckAuth;
use VuongCMS\System\Http\Middlewares\CheckSystem;

class SystemServiceProvider extends ServiceProvider
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
        $config = $this->app->make('config');
        $config->set('app.locale', 'vi');

        // php artisan vendor:publish --tag=common.lang --force
        $this->publishes([
            __DIR__.'/../Resources/Lang' => resource_path('lang'),
        ], 'common.lang');

        // php artisan vendor:publish --tag=common.assets --force
        $this->publishes([
            __DIR__.'/../Resources/Assets' => public_path('common'),
        ], 'common.assets');

        // Load resource
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../Views', 'system');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations', 'system');

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('check.auth', CheckAuth::class);
        $router->aliasMiddleware('check.system', CheckSystem::class);

        $this->app->bind(\App\Providers\AuthServiceProvider::class, \VuongCMS\System\Providers\AuthServiceProvider::class);
    }
}
