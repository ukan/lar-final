<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Session;

class UserAuth
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
        if(Sentinel::getUser() == NULL) {
            return redirect('login');
        } elseif (Sentinel::getUser()->inRole(2) == TRUE) {
            return $next($request);
        } else {
            Session::flash('error','Access denided');
            return redirect('/articles');
        }
    }
}
