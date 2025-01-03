<?php

namespace App\Services\Users\User;

use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class UserDeleteService extends Service
{
    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            'id' => 'required|int'
        ];
    }

    public function handle()
    {
        DB::transaction(function () {

            PersonalAccessToken::query()
                ->where('tokenable_type', User::class)
                ->where('tokenable_id', $this->params['id'])
                ->delete();

            User::query()
                ->where('id', $this->params['id'])
                ->delete();
        });
    }
}