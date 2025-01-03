<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

class AuthenticateUserByCookie
{
    public function handle(Request $request, Closure $next)
    {
        $token = $this->getTokenFromCookie($request);

        if ($token === null || $token === 'false') {
            return abort(403, 'Доступ запрещен');
        }

        try {
            $bearerToken = str_replace('Bearer ', '', $token);

            [$id, $token] = explode('|', $bearerToken, 2);
        } catch (Throwable) {

            throw abort(500, 'Что-то пошло не так');
        }

        $instance = PersonalAccessToken::query()
            ->with('tokenable')
            ->where('id', $id)
            ->first();

        if (!$instance) {
            return abort(403, 'Доступ запрещен');
        }

        $applicationToken = hash_equals($instance->token, hash('sha256', $token)) ? $instance : null;

        if (!$applicationToken) {
            return abort(403, 'Доступ запрещен');
        }

        Auth::setUser($applicationToken->tokenable);

        return $next($request);
    }

    private function getTokenFromCookie($request): string|null
    {
        if ($request->cookie('lsm__token_localAuth') === null && $request->cookie('backoffice_lsm__token_localAuth') === null) {
            return null;
        }

        if ($request->cookie('backoffice_lsm__token_localAuth') !== null) {
            return $request->cookie('backoffice_lsm__token_localAuth');
        }

        if ($request->cookie('lsm__token_localAuth') !== null) {
            return $request->cookie('lsm__token_localAuth');
        }

        return null;
    }
}
