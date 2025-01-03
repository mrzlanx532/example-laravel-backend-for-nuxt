<?php

namespace App\Services\Users\User;

use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserPasswordRestoreRequestCreateService extends Service
{
    public function getRules(): array
    {
        return [
            'email' => 'required|string|email:rfc,dns'
        ];
    }

    public function handle()
    {
        DB::transaction(function () {
            $user = User::query()
                ->where('email', $this->params['email'])
                ->first();

            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => trans('errors.the_user_with_specified_email_is_not_found')
                ]);
            }

            $user->temp_hash = Hash::make(uniqid() . $user->email);
            $user->password_new = $this->generatePassword();
            $user->save();
        });
    }

    private function generatePassword(): string
    {
        $allPossibleSymbols = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        start:

        $shuffledString = str_shuffle($allPossibleSymbols);

        $password = substr($shuffledString,0,8);

        if (preg_match('/^(?=.*([a-z]|[а-я]))(?=.*([A-Z]|[А-Я]))[0-9a-zа-яA-ZА-Я!@#$%^&*_]{8,}$/u', $password)) {
            return $password;
        }

        goto start;
    }
}