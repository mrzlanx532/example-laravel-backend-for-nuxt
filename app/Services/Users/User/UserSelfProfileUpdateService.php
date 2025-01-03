<?php

namespace App\Services\Users\User;

use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserSelfProfileUpdateService extends Service
{
    public function __construct()
    {
        $this->errorMessages = [
            'phone.unique' => trans('validation.unique', ['attribute' => app()->getLocale() === 'ru' ? 'Контактный телефон' : 'Contact phone'])
        ];
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users_users', 'phone')
                    ->whereNot('id', Auth::id())
                    ->whereNull('deleted_at')
            ],
            'company_url' => 'nullable|string|max:255',
            'company_business_type_id' => 'required|int|exists:users_company_business_types,id',
            'job_title' => 'required|string|max:255',
            'about' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'company_index' => 'required|string|max:255',
            'company_country_id' => 'required|int|exists:users_countries,id',
            'company_city' => 'required|string|max:255',
        ];
    }

    public function handle()
    {
        /* @var $user User */
        $user = Auth::user();

        $user->first_name = $this->params['first_name'];
        $user->last_name = $this->params['last_name'];
        $user->name = "{$user->last_name} {$user->first_name}";
        $user->phone = $this->params['phone'];
        $user->company_name = $this->params['company_name'];
        $user->company_address = $this->params['company_address'];
        $user->company_index = $this->params['company_index'];
        $user->company_country_id = $this->params['company_country_id'];
        $user->company_city = $this->params['company_city'];
        $user->company_url = array_key_exists('company_url', $this->params) ? $this->params['company_url'] : $user->company_url;
        $user->company_business_type_id = $this->params['company_business_type_id'];
        $user->job_title = $this->params['job_title'];
        $user->about = array_key_exists('about', $this->params) ? $this->params['about'] : $user->about;
        $user->save();
    }
}