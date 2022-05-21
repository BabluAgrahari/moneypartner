<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class EmployeeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            // if user is not admin take him to his dashboard
            if (Auth::user()->isRetailer()) {

                //check retialer otp verify or not
                if (empty(Auth::user()->verify_otp) || !Auth::user()->verify_otp)
                    return redirect(url('otp-sent'));

                return redirect(url('retailer/dashboard'));
            } else if (Auth::user()->isAdmin()) {  // allow admin to proceed with request
                if (empty(Auth::user()->verify_otp) || !Auth::user()->verify_otp)
                    return redirect(url('otp-sent'));

                return redirect(url('admin/dashboard'));
            } else if (Auth::user()->isDistributor()) {
                return redirect(url('distributor/dashboard'));
            } else if (Auth::user()->isEmployee()) {
                return $next($request);
            } else {
                return redirect(url('/'));
            }
        }

        //abort(404);  // for other user throw 404 error
        return redirect('/');
    }
}
