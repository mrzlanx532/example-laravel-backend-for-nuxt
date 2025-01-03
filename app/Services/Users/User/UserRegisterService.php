<?php

namespace App\Services\Users\User;

use App\Definitions\Users\User\StateDefinition;
use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserRegisterService extends Service
{
    public function __construct()
    {
        $this->errorMessages = [
            'password.regex' => trans('errors.password_must_contain'),
            'phone.unique' => trans('validation.unique', ['attribute' => app()->getLocale() === 'ru' ? 'Контактный телефон' : 'Contact phone'])
        ];
    }

    public function getRules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                Rule::unique('users_users', 'email')->whereNull('deleted_at')
            ],
            'phone' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users_users', 'phone')->whereNull('deleted_at')
            ],
            'company_url' => 'nullable|string|max:255',
            'company_business_type_id' => 'required|int|exists:users_company_business_types,id',
            'job_title' => 'required|string|max:255',
            'about' => 'nullable|string',
            'company_address' => 'required|string|max:255',
            'company_country_id' => 'required|int|exists:users_countries,id',
            'company_city' => 'required|string|max:255',
            'company_index' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'password' => [
                'required',
                'string',
                'confirmed',
                'regex:/^(?=.*([a-z]|[а-я]))(?=.*([A-Z]|[А-Я]))[0-9a-zа-яA-ZА-Я!@#$%^&*_]{8,}$/u'
            ],
            'is_agree' => 'required|bool'
        ];
    }

    public function handle(): void
    {
        DB::transaction(function () {
            $user = User::query()
                ->where('email', $this->params['email'])
                ->first();

            if ($user && $user->state_id === StateDefinition::ACTIVE) {
                throw ValidationException::withMessages([
                    'email' => trans('validation.unique', ['attribute' => 'email'])
                ]);
            }

            if ($user && $user->state_id === StateDefinition::DISABLED) {
                throw ValidationException::withMessages([
                    'email' => trans('errors.user_is_disabled')
                ]);
            }

            if ($user && $user->state_id === StateDefinition::PENDING) {
                return;
            }

            $user = new User;
            $user->company_url = $this->params['company_url'] ?? null;
            $user->company_business_type_id = $this->params['company_business_type_id'];
            $user->job_title = $this->params['job_title'];
            $user->about = $this->params['about'] ?? null;
            $user->company_address = $this->params['company_address'];
            $user->company_country_id = $this->params['company_country_id'];
            $user->company_city = $this->params['company_city'];
            $user->company_index = $this->params['company_index'];
            $user->first_name = $this->params['first_name'];
            $user->last_name = $this->params['last_name'];
            $user->name = "{$this->params['last_name']} {$this->params['first_name']}";
            $user->email = $this->params['email'];
            $user->phone = $this->params['phone'];
            $user->temp_hash = Hash::make(uniqid() . $user->email);
            $user->password = Hash::make($this->params['password']);
            $user->company_name = $this->params['company_name'];
            $user->locale_id = app()->getLocale();
            $user->save();
        });
    }
}