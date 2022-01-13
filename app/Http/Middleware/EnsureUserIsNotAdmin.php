<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth; 

class EnsureUserIsNotAdmin
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
                abort(404);
            }
            else 
            {
                return $next($request);
            }
        }
        else
        {
            return $next($request);
        }
    }
}
