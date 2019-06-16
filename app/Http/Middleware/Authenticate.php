<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Closure;
use Illuminate\Support\Facades\Input;


class Authenticate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('Authenticate')) {
            return $next($request);
        } else {
            return redirect(route('getLoginForm'));
        }
    }
}
