<?php

namespace VuongCMS\Cms;

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
        // Load resource
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/Views', 'cms');
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('auth.cms', Auth::class);
    }
}
