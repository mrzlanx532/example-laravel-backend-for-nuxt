<?php

namespace App\Services\Users\User;

use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserSelfPasswordUpdateService extends Service
{
    public function __construct()
    {
        $this->errorMessages = [
            'new_password.regex' => trans('errors.password_must_contain'),
        ];
    }

    public function getRules(): array
    {
        return [
            'current_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'confirmed',
                'regex:/^(?=.*([a-z]|[а-я]))(?=.*([A-Z]|[А-Я]))[0-9a-zа-яA-ZА-Я!@#$%^&*_]{8,}$/u'
            ],
        ];
    }

    public function handle(): string
    {
        /* @var $user User */
        $user = Auth::user();

        if (!Hash::check($this->params['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => trans('passwords.incorrect_password')
            ]);
        }

        $user->password = Hash::make($this->params['new_password']);
        $user->save();

        $user->tokens()->delete();

        return $user->createToken('basic authorization')->plainTextToken;
    }
}