<?php

namespace App\Services\Users\User;

use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\Hash;

class UserPasswordRestoreRequestApproveService extends Service
{
    public function getRules(): array
    {
        return [
            'hash' => 'required|string'
        ];
    }

    public function handle()
    {
        $user = User::query()
            ->where('temp_hash', $this->params['hash'])
            ->first();

        if (!$user) {
            throw abort(409, trans('errors.the_user_with_specified_email_is_not_found'));
        }

        $user->password = Hash::make($user->password_new);
        $user->password_new = null;
        $user->temp_hash = null;
        $user->save();
    }
}