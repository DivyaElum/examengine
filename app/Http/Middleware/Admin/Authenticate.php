<?php

namespace App\Http\Middleware\Admin;

use Closure;

use App\SiteSetting;
use Session;

class Authenticate
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
        //$user = auth()->check();
        if(auth()->check())
        {
            if(!auth()->user()->hasRole('admin'))
            {
                auth()->logout();
                return redirect('/admin/login');
            }

            $arrSiteSetting = SiteSetting::find('1');
            view()->share('siteSetting', $arrSiteSetting);
            return $next($request);
        }
        else
        {
            return redirect('/admin/login');
        }
    }
}
