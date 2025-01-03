<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

class AuthenticateUserByBearerTokenWithoutException
{
    public function handle(Request $request, Closure $next)
    {
        $applicationToken = null;

        if ($request->bearerToken() === null) {
            return $next($request);
        }

        if (!str_contains($request->bearerToken(), '|')) {
            $applicationToken = PersonalAccessToken::query()
                ->with('tokenable')
                ->where('token', hash('sha256', $request->bearerToken()))
                ->first();
        }

        try {
            [$id, $token] = explode('|', $request->bearerToken(), 2);
        } catch (Throwable) {
            throw abort(500, 'Что-то пошло не так');
        }

        if (
            $instance = PersonalAccessToken::query()
                ->with('tokenable')
                ->where('id', $id)
                ->first()
        ) {
            $applicationToken = hash_equals($instance->token, hash('sha256', $token)) ? $instance : null;
        }

        if ($applicationToken) {
            Auth::setUser($applicationToken->tokenable);
        }

        return $next($request);
    }
}
