<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class Pelanggan
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
        if(Auth::check() && Auth::user()->jenis == "Pelanggan" || Auth::user()->jenis == "Anggota_Kopkar")
        {
            return $next($request);
        }
        else 
        {
            abort(404);
        }
    }
}
