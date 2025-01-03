<?php

namespace App\Services\Managers\Manager;

use App\Models\Managers\Manager;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class ManagerDeleteService extends Service
{
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
                ->where('tokenable_type', Manager::class)
                ->where('tokenable_id', $this->params['id'])
                ->delete();

            Manager::query()
                ->where('id', $this->params['id'])
                ->delete();
        });
    }
}