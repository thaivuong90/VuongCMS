<?php

use Illuminate\Support\Str;

if (!function_exists('system_route')) {
  /**
   * Generate the URL to a named route.
   *
   * @param  array|string  $name
   * @param  mixed  $parameters
   * @param  bool  $absolute
   * @return string
   */
  function system_route($name, $parameters = [])
  {
    $slugParam = request()->route('slug') ? request()->route('slug') : null;
    if ($slugParam) $parameters['slug'] = $slugParam;
    return app('url')->route($name, $parameters);
  }
}

if (!function_exists('slug')) {
  /**
   * slug
   *
   * @param  array|string  $name
   * @param  mixed  $parameters
   * @param  bool  $absolute
   * @return string
   */
  function slug($name)
  {
    return Str::of($name)->slug('-');
  }
}