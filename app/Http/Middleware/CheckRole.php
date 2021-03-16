<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
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
        if (count(array_intersect($roles, json_decode($request->user()->roles))) > 0) return $next($request);

        return abort(403, "Unathorized", ['actionLink' => route('home'), 'actionTitle' => "Back To Home"]);
    }
}
