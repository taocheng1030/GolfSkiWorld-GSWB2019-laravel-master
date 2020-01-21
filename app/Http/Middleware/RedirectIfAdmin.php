<?php namespace App\Http\Middleware;

use Closure;

class RedirectIfAdmin
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (\Shinobi::is('admin')) {
            return $next($request);
        }

        return redirect('/');
    }
}