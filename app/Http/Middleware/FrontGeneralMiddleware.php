<?php

namespace App\Http\Middleware;

use Closure;
use App\SiteSetting;


class FrontGeneralMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $arrSiteSetting = SiteSetting::find('1');
        view()->share('siteSetting', $arrSiteSetting);
        return $next($request);
    }
}
