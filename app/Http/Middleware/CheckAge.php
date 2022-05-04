<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * This middleware will check if age > 18, if yes it will navigate to the requested url else it will redirect
 * to welcome page
 */
class CheckAge
{
    /**
     * Handle an incoming requests
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->age <= 18) {
            return redirect('/');
        }
        return $next($request);
    }
}
