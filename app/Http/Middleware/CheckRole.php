<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * @param $request
     * @param Closure $next
     * @param $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle($request, Closure $next, $role) {
        if (Auth::check() && Auth::user()->role->name == $role) {
            return $next($request);
        }

        return redirect('/');
    }
}
