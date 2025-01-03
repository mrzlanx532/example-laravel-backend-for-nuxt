<?php

namespace App\Services\Users\User;

use App\Definitions\Users\User\StateDefinition;
use App\Events\UserDisabled;
use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\DB;

class UserDisableService extends Service
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
            $user = User::query()->findOrFail($this->params['id']);
            $user->state_id = StateDefinition::DISABLED;
            $user->save();

            UserDisabled::dispatch($user->id);

            $user->tokens()->delete();
        });
    }
}