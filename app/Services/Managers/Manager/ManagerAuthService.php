<?php

namespace App\Services\Managers\Manager;

use App\Http\Resources\Backoffice\Managers\Manager\ManagerResource;
use App\Models\Managers\Manager;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ManagerAuthService extends Service
{
    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            'email' => 'required|string|email:rfc,dns|max:255',
            'password' => 'required|string|max:255'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function handle(): array
    {
        $manager = Manager::query()
            ->where('email', $this->params['email'])
            ->first();

        if (!$manager) {
            throw ValidationException::withMessages([
                'email' => trans('validation.exists', ['attribute' => 'email'])
            ]);
        }

        if (!Hash::check($this->params['password'], $manager->password)) {
            throw ValidationException::withMessages([
                'password' => trans('auth.password')
            ]);
        }

        return [
            'user' => new ManagerResource($manager),
            'token_type' => 'Bearer',
            'token' => $manager->createToken('basic authorization')->plainTextToken
        ];
    }
}