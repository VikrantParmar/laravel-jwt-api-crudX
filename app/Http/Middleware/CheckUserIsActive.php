<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Enums\AdminStatus;
class CheckUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        #dd(auth()->guard('admin')->user()->status !== AdminStatus::ACTIVE->value, AdminStatus::ACTIVE->value, auth()->guard('admin')->user()->status->value);
        #if (auth()->guard('admin')->user()->status !== AdminStatus::ACTIVE->value) {
        if (auth()->guard('admin')->user()->status->value !== AdminStatus::ACTIVE->value) {
            #die("in checkuser is active");
            Auth::guard('admin')->logout();
            return redirect(route('admin.auth.login'));
        }

        return $next($request);
    }
}
