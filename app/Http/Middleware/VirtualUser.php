<?php

namespace App\Http\Middleware;

use Closure;

class VirtualUser
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
        if ($request->session()->has('system_admin')) {
            return $next($request);
        }
        return redirect()->guest('virtual/login');

        return $next($request);
    }
}
