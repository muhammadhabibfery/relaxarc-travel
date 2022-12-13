<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {

            // if ($request->is('profile*') || $request->is('checkout*')) return abort(401);
            if ($request->is('checkout*')) {
                $request->session()->put('guest-route', $request->path());
                return abort(401);
            }

            return route('login');
        }
    }
}
