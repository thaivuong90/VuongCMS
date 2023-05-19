<?php

namespace VuongCMS\Cms\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use VuongCMS\Cms\Middlewares\Auth;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $config = $this->app->make('config');
        $config->set('app.name', 'Lucky Ticket');
        $config->set('app.locale', 'vi');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // php artisan vendor:publish --tag=cms.assets --force
        $this->publishes([
            __DIR__.'/../Assets' => public_path('cms'),
        ], 'cms.assets');

        // php artisan vendor:publish --tag=cms.lang --force
        $this->publishes([
            __DIR__.'/../Lang' => resource_path('lang'),
        ], 'cms.lang');

        // Load resource
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../Views', 'cms');
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('auth.cms', Auth::class);
    }
}
