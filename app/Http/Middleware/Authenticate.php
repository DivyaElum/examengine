<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use App\SiteSetting;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        $arrSiteSetting = SiteSetting::find('1');
        view()->share('siteSetting', $arrSiteSetting);
        return $next($request);
    }
}
