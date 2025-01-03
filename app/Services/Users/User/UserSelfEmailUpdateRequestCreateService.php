<?php

namespace App\Services\Users\User;

use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserSelfEmailUpdateRequestCreateService extends Service
{
    public function __construct()
    {
        $this->errorMessages['email_new.unique'] = trans('errors.the_value_of_the_email_field_is_already_taken');
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            'email_new' => [
                'required',
                'string',
                'max:255',
                'email:rfc,dns',
                Rule::unique('users_users', 'email')->whereNull('deleted_at')->whereNot('id', Auth::id())
            ]
        ];
    }

    public function handle()
    {
        DB::transaction(function () {
            /* @var $currentUser User */
            $currentUser = Auth::user();

            if ($currentUser->email === $this->params['email_new']) {
                throw ValidationException::withMessages([
                    'email_new' => trans('errors.the_passed_email_is_equal_to_the_current_one')
                ]);
            }

            $currentUser->email_new = $this->params['email_new'];
            $currentUser->temp_hash = Hash::make(uniqid() . $currentUser->email_new);
            $currentUser->save();
        });
    }
}