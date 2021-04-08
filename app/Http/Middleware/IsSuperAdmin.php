<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (count(array_intersect($roles, $request->user()->roles)) > 1) return $next($request);

        return abort(403, 'Unathorized', ['actionLink' => route('dashboard'), 'actionTitle' => __("Back to dashboard")]);
    }
}
