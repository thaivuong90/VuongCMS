<?php

namespace VuongCMS\System;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use VuongCMS\System\Middlewares\CheckAuth;
use VuongCMS\System\Middlewares\CheckSystem;

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
        // Load resource
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/Views', 'system');

        // Artisan::call('vendor:publish', [
        //     '--tag' => ['common.lang'],
        //     '--force' => true,
        // ]);
        // $router = $this->app->make(Router::class);
        // $router->aliasMiddleware('install.cms', Install::class);

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('check.auth', CheckAuth::class);
        $router->aliasMiddleware('check.system', CheckSystem::class);
    }
}
