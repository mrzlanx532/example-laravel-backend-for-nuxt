<?php

namespace App\Services\Users\User;

use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Carbon;

class UserSelfEmailUpdateRequestApproveService extends Service
{
    /**
     * @return array
     */
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
            throw abort(409, trans('errors.specified_hash_is_invalid'));
        }

        $user->temp_hash = null;
        $user->email = $user->email_new;
        $user->email_new = null;
        $user->email_verified_at = Carbon::now()->toDateTimeString();
        $user->save();
    }
}