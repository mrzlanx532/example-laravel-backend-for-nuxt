<?php

namespace App\Services\Users\User;

use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserSelfProfileDeleteService extends Service
{
    public function handle()
    {
        DB::transaction(function () {
            /* @var $user User */
            $user = Auth::user();

            $user->tokens()->delete();
            $user->delete();
        });
    }
}