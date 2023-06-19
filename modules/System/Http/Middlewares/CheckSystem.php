<?php

namespace VuongCMS\System\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use VuongCMS\Shared\Models\System;

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
    $slug = $request->route('slug');
    // Cache system data
    // $system = Cache::remember('cache-' . $slug, 216000, function() use($slug) {
    //   return System::where('slug', $slug)->first();
    // });
    $system = System::where('slug', $slug)->first();
    if (!$system) return abort(404);
    $request->merge(['system_id' => $system->getKey()]);
    View::share('system', $system);
    return $next($request);
  }
}
