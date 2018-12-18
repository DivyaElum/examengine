<?php

namespace App\Http\Middleware\Admin;

use Closure;

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
            return $next($request);
        }
        else
        {
            return redirect('/admin/login');
        }
        
        
    }
}
