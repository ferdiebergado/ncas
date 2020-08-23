<?php

namespace App\Http\Middleware;

use Closure;

class TelescopeAuth
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
        if (app()->environment('local') || in_array(optional($request->user())->email, config("custom.telescope.authorized_emails"))) {
            return $next($request);
        }

        return abort(403);
    }
}
