<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (count(array_intersect(["ADMIN"], json_decode(Auth::guard($guard)->user()->roles))) > 0)
                    return redirect()->intended(route('dashboard'));

                if (is_null(Auth::guard($guard)->user()->phone) || is_null(Auth::guard($guard)->user()->address)) return redirect()->route('front-profile');


                return redirect()->intended(route('home'));
            }
        }

        return $next($request);
    }
}
