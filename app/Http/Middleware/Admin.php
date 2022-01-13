<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
        {
            if(Auth::user()->jenis == "Admin" || Auth::user()->jenis == "Manajer")
            {
                return $next($request);
            }
            else 
            {
                abort(404);
            }
        }
        else 
        {
            abort(404);
        }
    }
}
