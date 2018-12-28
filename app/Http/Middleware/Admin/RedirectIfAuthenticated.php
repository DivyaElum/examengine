<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(auth()->check())
        {
            if(!auth()->user()->hasRole('admin'))
            {
                auth()->logout();
                return redirect('/admin/login');
            }
            
            return redirect('/admin/dashboard');
        }

        return $next($request);
    }
}
