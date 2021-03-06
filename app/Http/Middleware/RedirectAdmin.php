<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectAdmin
{

    public function handle(Request $request, Closure $next)
    {
        $role = (!empty(Auth::user())) ? Auth::user()->isAdmin() : false; //check role

        if ($role) {
            if (empty(Auth::user()->verify_otp) || !Auth::user()->verify_otp)
                return $next($request);

            return redirect(url('admin/dashboard'));
        }

        return $next($request);
    }
}
