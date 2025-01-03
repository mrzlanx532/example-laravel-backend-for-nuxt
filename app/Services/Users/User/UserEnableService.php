<?php

namespace App\Services\Users\User;

use App\Definitions\Users\User\StateDefinition;
use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;

class UserEnableService extends Service
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
        $user = User::query()->findOrFail($this->params['id']);
        $user->state_id = StateDefinition::ACTIVE;
        $user->save();
    }
}