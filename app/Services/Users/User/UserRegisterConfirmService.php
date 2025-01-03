<?php

namespace App\Services\Users\User;

use App\Definitions\Users\User\StateDefinition;
use App\Http\Resources\Backoffice\Users\User\UserForDetailResource;
use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Carbon;

class UserRegisterConfirmService extends Service
{
    public function getRules(): array
    {
        return [
            'hash' => 'required|string|max:255',
        ];
    }

    public function handle(): array
    {
        $user = User::query()
            ->where('state_id', StateDefinition::PENDING)
            ->where('temp_hash', $this->params['hash'])
            ->first();

        if (!$user) {
            throw abort(409, trans('errors.something_went_wrong'));
        }

        $user->temp_hash = null;
        $user->state_id = StateDefinition::ACTIVE;
        $user->email_verified_at = Carbon::now()->toDateTimeString();
        $user->save();

        return [
            'user' => new UserForDetailResource($user),
            'token_type' => 'Bearer',
            'token' => $user->createToken('basic authorization', expiresAt: Carbon::now()->addDays(7))->plainTextToken
        ];
    }
}