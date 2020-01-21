<?php

namespace App\Http\Middleware;

use Closure;
use Caffeinated\Shinobi\Facades\Shinobi;

class RedirectIfBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Shinobi::is('banned'))
            return view('banned');


        return $next($request);
    }
}
