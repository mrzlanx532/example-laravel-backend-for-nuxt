<?php

namespace App\Http\Resources\Backoffice\Managers\Manager;

use Mrzlanx532\LaravelBasicComponents\Traits\Model\UploadFile\Exceptions\InvalidFilePropertiesWithSettingsPropertyConfiguration;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Managers\Manager;
use Illuminate\Support\Carbon;

class ManagerResource extends JsonResource
{
    /* @var $resource Manager */
    public $resource;

    /**
     * @throws InvalidFilePropertiesWithSettingsPropertyConfiguration
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'picture' => $this->resource->getFileLinksBySettings('picture'),
            'created_at' => $this->resource->created_at ? Carbon::parse($this->resource->created_at)->timestamp : null,
            'updated_at' => $this->resource->updated_at ? Carbon::parse($this->resource->updated_at)->timestamp : null,
        ];
    }
}