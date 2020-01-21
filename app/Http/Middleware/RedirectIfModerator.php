<?php namespace App\Http\Middleware;

use Closure;

class RedirectIfModerator
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (\Shinobi::is('admin') || \Shinobi::is('moderator')) {
            return $next($request);
        }

        return redirect('/');
    }
}