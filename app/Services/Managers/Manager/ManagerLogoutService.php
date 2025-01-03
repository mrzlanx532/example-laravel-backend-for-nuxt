<?php

namespace App\Services\Managers\Manager;

use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class ManagerLogoutService extends Service
{
    public function handle(): void
    {
        /* @var $request Request */
        $request = request();

        /* @var $model PersonalAccessToken */
        $model = Sanctum::$personalAccessTokenModel;

        $accessToken = $model::findToken($request->bearerToken());
        $accessToken->delete();
    }
}