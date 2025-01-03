<?php

namespace App\Services\Users\User;

use App\Definitions\LocaleDefinition;
use App\Definitions\Users\User\SubscriptionTypeDefinition;
use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\Service\Service;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserUpdateService extends Service
{
    public function __construct()
    {
        $this->errorMessages = [
            'subscription_till.required_if' => trans('validation.required'),
        ];
    }

    public function getRules(): array
    {
        return [
            'id' => 'required|int',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'company_city' => 'required|string|max:255',
            'company_country_id' => 'required|int|exists:users_countries,id',
            'company_index' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'picture' => 'nullable|image|max:10240',
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
            'content' => 'nullable|string',
        ];
    }

    public function handle()
    {
        DB::transaction(function () {
            $user = User::query()
                ->where('id', $this->params['id'])
                ->firstOrFail();

            $userWithPassedEmailAreExists = User::query()
                ->where('id', '!=', $this->params['id'])
                ->where('email', $this->params['email'])
                ->exists();

            if ($userWithPassedEmailAreExists) {
                throw ValidationException::withMessages([
                    'email' => trans('validation.unique', ['attribute' => trans('entity_fields.user.email')])
                ]);
            }

            $userWithPassedPhoneAreExists = User::query()
                ->where('id', '!=', $this->params['id'])
                ->where('phone', $this->params['phone'])
                ->exists();

            if ($userWithPassedPhoneAreExists) {
                throw ValidationException::withMessages([
                    'phone' => trans('validation.unique', ['attribute' => trans('entity_fields.user.phone')])
                ]);
            }

            $user->first_name = $this->params['first_name'];
            $user->last_name = $this->params['last_name'];
            $user->name = "{$user->last_name} {$user->first_name}";
            $user->email = $this->params['email'];
            $user->phone = $this->params['phone'];
            $user->description = array_key_exists('description', $this->params) ? $this->params['description'] : $user->description;
            $user->picture = array_key_exists('picture', $this->params) ? $this->params['picture'] : $user->picture;
            $user->company_name = $this->params['company_name'];
            $user->company_address = array_key_exists('company_address', $this->params) ? $this->params['company_address'] : $user->company_address;
            $user->company_city = array_key_exists('company_city', $this->params) ? $this->params['company_city'] : $user->company_city;
            $user->company_country_id = array_key_exists('company_country_id', $this->params) ? $this->params['company_country_id'] : $user->company_country_id;
            $user->company_index = array_key_exists('company_index', $this->params) ? $this->params['company_index'] : $user->company_index;
            $user->subscription_till = $this->getSubscriptionTill($user);
            $user->subscription_till_for_exclusive_tracks = $this->getSubscriptionTillForExclusiveTracks($user);
            $user->subscription_type_id = $this->params['subscription_type_id'] ?? $user->subscription_type_id;
            $user->company_url = array_key_exists('company_url', $this->params) ? $this->params['company_url'] : $user->company_url;
            $user->company_business_type_id = $this->params['company_business_type_id'];
            $user->job_title = $this->params['job_title'];
            $user->about = array_key_exists('about', $this->params) ? $this->params['about'] : $user->about;
            $user->locale_id = $this->params['locale_id'];
            $user->content = array_key_exists('content', $this->params) ? $this->params['content'] : $user->content;
            $user->save();
        });
    }

    private function getSubscriptionTillForExclusiveTracks(User $user): Carbon|string|null
    {
        if (!array_key_exists('subscription_till_for_exclusive_tracks', $this->params)) {
            return $user->subscription_till_for_exclusive_tracks;
        }

        if ($this->params['subscription_till_for_exclusive_tracks'] === null) {
            return null;
        }

        return Carbon::createFromFormat('d.m.Y', $this->params['subscription_till_for_exclusive_tracks'])->toDateString();
    }

    private function getSubscriptionTill(User $user): Carbon|string|null
    {
        if (isset($this->params['subscription_type_id']) && $this->params['subscription_type_id'] === SubscriptionTypeDefinition::NONE) {
            return null;
        }

        if (array_key_exists('subscription_till', $this->params)) {

            if (!$this->params['subscription_till']) {
                return null;
            }

            return Carbon::createFromFormat('d.m.Y', $this->params['subscription_till'])->toDateString();
        }

        return $user->subscription_till;
    }
}