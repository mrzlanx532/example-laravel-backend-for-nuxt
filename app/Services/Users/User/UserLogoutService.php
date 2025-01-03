<?php

namespace App\Services\Users\User;

use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\PersonalAccessToken;

class UserLogoutService extends Service
{
    public function handle()
    {
        /* @var $request Request */
        $request = request();

        /* @var $model PersonalAccessToken */
        $model = Sanctum::$personalAccessTokenModel;

        $accessToken = $model::findToken($request->bearerToken());
        $accessToken->delete();
    }
}