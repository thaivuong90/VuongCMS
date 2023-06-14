<?php

namespace VuongCMS\System\Middlewares;

use Closure;
use Illuminate\Http\Request;
use VuongCMS\Common\Models\System;

class CheckSystem
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
    if (!$request->slug) return abort(404);
    $system = System::where('url', $request->slug)->first();
    if ($system) return abort(404);
    $request->merge(['system_id' => $system->getKey()]);
    return $next($request);
  }
}
