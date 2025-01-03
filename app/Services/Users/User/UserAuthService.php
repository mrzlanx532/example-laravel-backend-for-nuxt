<?php

namespace App\Services\Users\User;

use App\Definitions\Users\User\StateDefinition;
use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Backoffice\Users\User\UserForDetailResource;

class UserAuthService extends Service
{
    public function getRules(): array
    {
        return [
            'email' => 'required|string|email:rfc,dns',
            'password' => 'required|string|max:255',
            'is_remember' => 'required|bool'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function handle(): array
    {
        $user = User::query()
            ->where('email', $this->params['email'])
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => trans('validation.exists', ['attribute' => 'email'])
            ]);
        }

        if ($user->state_id === StateDefinition::DISABLED) {
            throw ValidationException::withMessages([
                'email' => trans('errors.user_is_disabled')
            ]);
        }

        if (!Hash::check($this->params['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => trans('auth.password')
            ]);
        }

        return [
            'user' => new UserForDetailResource($user),
            'token_type' => 'Bearer',
            'token' => $user->createToken('basic authorization', expiresAt: $this->params['is_remember'] ? null: Carbon::now()->addDays(7))->plainTextToken
        ];
    }
}