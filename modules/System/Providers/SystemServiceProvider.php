<?php

namespace VuongCMS\System\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class SystemServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\VuongCMS\System\Http\Interfaces\SystemInterface::class, \VuongCMS\System\Http\Services\SystemService::class);
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
            module_path('System/Resources/Lang') => resource_path('lang'),
        ], 'common.lang');

        // php artisan vendor:publish --tag=common.assets --force
        $this->publishes([
            module_path('Resources/Assets') => public_path('common'),
        ], 'common.assets');

        // Load resource
        $this->loadRoutesFrom(module_path('System/Routes/web.php'));
        $this->loadViewsFrom(module_path('System/Views'), 'system');
        $this->loadMigrationsFrom(module_path('Database/Migrations'), 'system');

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('check.auth', \VuongCMS\System\Http\Middlewares\CheckAuth::class);
        $router->aliasMiddleware('check.system', \VuongCMS\System\Http\Middlewares\CheckSystem::class);

    }
}
