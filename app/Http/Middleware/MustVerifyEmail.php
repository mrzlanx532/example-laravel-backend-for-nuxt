<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MustVerifyEmail
{
    public function handle(Request $request, Closure $next)
    {
        if (
            !$request->user() ||
            ($request->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$request->user()->hasVerifiedEmail())
        ) {
            throw abort(403, trans('errors.have_not_confirmed_your_email'));
        }

        return $next($request);
    }
}
