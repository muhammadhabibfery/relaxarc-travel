<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticatedRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $userRoles = $request->user()->roles;

        if (checkRoles($roles, $userRoles)) return $next($request);

        $redirectRoute = in_array("MEMBER", $userRoles) ? [route('home'), "Back to home"] : [route('dashboard'), "Back to dashboard"];

        return abort(403, 'Unathorized', ['actionLink' => $redirectRoute[0], 'actionTitle' => __($redirectRoute[1])]);


        // $totalRoles = array_pop($roles);
        // $userRoles = $request->user()->roles;

        // if (count(array_intersect($roles, $userRoles)) >= $totalRoles) return $next($request);

        // return (in_array("MEMBER", $userRoles, true)) ?
        //     abort(403, 'Unathorized', ['actionLink' => route('home'), 'actionTitle' => __("Back to home")])
        //     :
        //     abort(403, 'Unathorized', ['actionLink' => route('dashboard'), 'actionTitle' => __("Back to dashboard")]);
    }
}
