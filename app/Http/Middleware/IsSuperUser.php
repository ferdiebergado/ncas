<?php

namespace App\Http\Middleware;

use Closure;

class IsSuperUser
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
        if (app()->environment('local')) {
            return $next($request);
        }

        if (in_array(auth()->user()->email, config("custom.telescope.authorized_emails"))) {
            return $next($request);
        }

        abort(403);
    }
}
