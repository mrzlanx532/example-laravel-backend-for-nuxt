<?php

namespace App\Services\Users\User;

use App\Events\UserLogout;
use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserPasswordResetService extends Service
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

    /**
     * Сбросить пароль для пользователя из админки
     */
    public function handle()
    {
        $user = User::query()
            ->with('tokens')
            ->where('id', $this->params['id'])
            ->firstOrFail();

        $newPassword = $this->generatePassword();

        $user->password = Hash::make($newPassword);
        $user->save();

        UserLogout::dispatch($user->id);

        $user->tokens()->delete();
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