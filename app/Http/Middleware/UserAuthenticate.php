<?php

namespace App\Http\Middleware;

use Closure;

use App\User as UserModel;
use App\SiteSetting;

class UserAuthenticate
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
            $arrSiteSetting = SiteSetting::find('1');

            $user_id = auth()->user()->id;
            $arrUsers = UserModel::with(['information'])->find($user_id);  //get login user data
            view()->share('arrUserData', $arrUsers);
            view()->share('siteSetting', $arrSiteSetting);
            return $next($request);
        }
        else
        {
            return redirect('/signup');
        }
    }
}
