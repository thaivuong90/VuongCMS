<?php

namespace VuongCMS\System\Middlewares;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class CheckAuth extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->system_id || !$request->expectsJson()) {
            return system_route('system.login');
        }
    }
}
