<?php

namespace App\Services\Users\User;

use App\Definitions\LocaleDefinition;
use App\Definitions\Users\User\StateDefinition;
use App\Definitions\Users\User\SubscriptionTypeDefinition;
use App\Models\Users\User;
use App\Models\Users\UserSubscriptionLabel;
use Closure;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserCreateService extends Service
{
    public function __construct()
    {
        $this->errorMessages = [
            'password.regex' => trans('errors.password_must_contain'),
            'subscription_till.required_if' => trans('validation.required')
        ];
    }

    public function getRules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns',
            'phone' => 'required|string|max:255',
            'description' => 'nullable|string',
            'picture' => 'nullable|image|max:10240',
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'company_index' => 'required|string|max:255',
            'company_country_id' => 'required|int|exists:users_countries,id',
            'company_city' => 'required|string|max:255',
            'password' => [
                'required',
                'string',
                'confirmed',
                'regex:/^(?=.*([a-z]|[а-я]))(?=.*([A-Z]|[А-Я]))[0-9a-zа-яA-ZА-Я!@#$%^&*_]{8,}$/u'
            ],
            'subscription_till' => 'required_if:subscription_type_id,ONLY_MUSIC,ONLY_SOUNDS,MUSIC_AND_SOUNDS|date_format:d.m.Y',
            'subscription_till_for_exclusive_tracks' => 'nullable|date_format:d.m.Y',
            'subscription_type_id' => 'nullable|string|in:' . SubscriptionTypeDefinition::getValuesThroughComma(),
            'subscription_labels' => [
                Rule::requiredIf(function () {
                    return
                        request()->has('subscription_type_id') &&
                        in_array(request()->get('subscription_type_id'), [
                            SubscriptionTypeDefinition::ONLY_MUSIC,
                            SubscriptionTypeDefinition::MUSIC_AND_SOUNDS
                        ]);
                }),
                'array'
            ],
            'subscription_labels.*' => 'required|int|exists:legio_music_labels,id',
            'company_url' => 'nullable|string|max:255',
            'company_business_type_id' => 'required|int|exists:users_company_business_types,id',
            'job_title' => 'required|string|max:255',
            'about' => 'nullable|string',
            'locale_id' => 'required|string|in:' . LocaleDefinition::getValuesThroughComma(),
            'is_checked' => [
                'required',
                'bool',
                function (string $attr, mixed $value, Closure $fail) {
                    if ($value === false) {
                        $fail('Поле обязательно для заполнения');
                    }
                }
            ],
            'content' => 'nullable|string'
        ];
    }

    /**
     * @throws ValidationException
     */
    public function handle()
    {
        DB::transaction(function () {
            $userWithSpecifiedEmailAreExists = User::query()
                ->where('email', $this->params['email'])
                ->first();

            if ($userWithSpecifiedEmailAreExists) {
                throw ValidationException::withMessages([
                    'email' => trans('validation.unique', ['attribute' => trans('entity_fields.user.email')])
                ]);
            }

            $userWithSpecifiedPhoneAreExists = User::query()
                ->where('phone', $this->params['phone'])
                ->exists();

            if ($userWithSpecifiedPhoneAreExists) {
                throw ValidationException::withMessages([
                    'phone' => trans('validation.unique', ['attribute' => trans('entity_fields.user.phone')])
                ]);
            }

            $user = new User;
            $user->first_name = $this->params['first_name'];
            $user->last_name = $this->params['last_name'];
            $user->name = "{$this->params['last_name']} {$this->params['first_name']}";
            $user->email = $this->params['email'];
            $user->phone = $this->params['phone'];
            $user->description = $this->params['description'] ?? null;
            $user->picture = $this->params['picture'] ?? null;
            $user->company_name = $this->params['company_name'];
            $user->company_address = $this->params['company_address'] ?? null;
            $user->company_index = $this->params['company_index'] ?? null;
            $user->company_country_id = $this->params['company_country_id'] ?? null;
            $user->company_city = $this->params['company_city'] ?? null;
            $user->temp_hash = Hash::make(uniqid() . $user->email);
            $user->password = Hash::make($this->params['password']);
            $user->company_name = $this->params['company_name'];
            $user->subscription_type_id = $this->params['subscription_type_id'] ?? SubscriptionTypeDefinition::NONE;
            $user->subscription_till = isset($this->params['subscription_till']) ? Carbon::createFromFormat('d.m.Y', $this->params['subscription_till']) : null;
            $user->subscription_till_for_exclusive_tracks = isset($this->params['subscription_till_for_exclusive_tracks']) ? Carbon::createFromFormat('d.m.Y', $this->params['subscription_till_for_exclusive_tracks']) : null;
            $user->company_url = $this->params['company_url'] ?? null;
            $user->company_business_type_id = $this->params['company_business_type_id'];
            $user->job_title = $this->params['job_title'];
            $user->about = $this->params['about'] ?? null;
            $user->locale_id = $this->params['locale_id'];
            $user->state_id = StateDefinition::ACTIVE;
            $user->email_verified_at = Carbon::now()->toDateTimeString();
            $user->content = $this->params['content'] ?? null;
            $user->save();

            if (
                isset($this->params['subscription_type_id']) &&
                in_array($this->params['subscription_type_id'], [SubscriptionTypeDefinition::ONLY_MUSIC, SubscriptionTypeDefinition::MUSIC_AND_SOUNDS])
            ) {
                $insertItems = [];

                foreach ($this->params['subscription_labels'] as $labelId) {
                    $insertItems[] = [
                        'label_id' => $labelId,
                        'user_id' => $user->id
                    ];
                }

                UserSubscriptionLabel::insert($insertItems);
            }
        });
    }
}