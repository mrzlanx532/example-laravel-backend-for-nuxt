<?php

namespace App\Http\Resources\Backoffice\Users\User;

use App\Definitions\Users\User\StateDefinition;
use App\Definitions\Users\User\SubscriptionTypeDefinition;
use App\Models\Users\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use stdClass;

class UserForDetailResource extends JsonResource
{
    /* @var $resource User|stdClass */
    public $resource;

    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'email_verified_at' => $this->resource->email_verified_at ? Carbon::parse($this->resource->email_verified_at)->timestamp : null,
            'remember_token' => $this->resource->remember_token,
            'created_at' => $this->resource->created_at ? Carbon::parse($this->resource->created_at)->timestamp : null,
            'updated_at' => $this->resource->updated_at ? Carbon::parse($this->resource->updated_at)->timestamp : null,
            'email_new' => $this->resource->email_new,
            'picture' => $this->resource->getFileLinksBySettings('picture'),
            'phone' => $this->resource->phone,
            'state_id' => $this->resource->state_id,
            'state' => StateDefinition::getItemByConst($this->resource->state_id),
            'subscription_type_id' => $this->resource->subscription_type_id,
            'subscription_type' => SubscriptionTypeDefinition::getItemByConst($this->resource->subscription_type_id),
            'subscription_till' => $this->resource->subscription_till ? Carbon::parse($this->resource->subscription_till)->timestamp : null,
            'subscription_till_for_exclusive_tracks' => $this->resource->subscription_till_for_exclusive_tracks ? Carbon::parse($this->resource->subscription_till_for_exclusive_tracks)->timestamp : null,
            'description' => $this->resource->description,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'company_name' => $this->resource->company_name,
            'company_address' => $this->resource->company_address,
            'company_index' => $this->resource->company_index,
            'company_city' => $this->resource->company_city,
            'company_country' => $this->getCompanyCountry(),
            'downloads_counter' => $this->resource->downloads_counter,
            'views_counter' => $this->resource->views_counter,
            'company_url' => $this->resource->company_url,
            'job_title' => $this->resource->job_title,
            'about' => $this->resource->about,
            'company_business_type_id' => $this->resource->company_business_type_id,
            'company_business_type' => $this->getCompanyBusinessType(),
            'locale_id' => $this->resource->locale_id,
            'subscription_labels' => $this->getSubscriptionLabels()
        ];
    }

    private function getSubscriptionLabels(): mixed
    {
        return $this->resource->subscriptionsLabels->map(function ($label) {
            return [
                'id' => $label->id,
                'name_ru' => $label->name_ru,
                'name_en' => $label->name_en,
            ];
        });
    }

    private function getCompanyBusinessType(): ?array
    {
        if (!$this->resource->users_company_business_types_id) {
            return null;
        }

        return [
            'id' => $this->resource->users_company_business_types_id,
            'name_ru' => $this->resource->users_company_business_types_name_ru,
            'name_en' => $this->resource->users_company_business_types_name_en,
        ];
    }

    private function getCompanyCountry(): ?array
    {
        if (!$this->resource->users_countries_id) {
            return null;
        }

        return [
            'id' => $this->resource->users_countries_id,
            'name_ru' => $this->resource->users_countries_name_ru,
            'name_en' => $this->resource->users_countries_name_en,
        ];
    }
}