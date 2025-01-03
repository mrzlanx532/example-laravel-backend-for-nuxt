<?php

namespace App\Http\Resources\Backoffice\Objects\Obj;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Objects\Obj;
use Illuminate\Support\Carbon;
use Mrzlanx532\LaravelBasicComponents\Traits\Model\UploadFile\Exceptions\InvalidFilePropertiesWithSettingsPropertyConfiguration;

class ObjectResource extends JsonResource
{
    /* @var $resource Obj */
    public $resource;

    /**
     * @throws InvalidFilePropertiesWithSettingsPropertyConfiguration
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'example_checkbox' => $this->resource->example_checkbox,
            'example_date' => $this->resource->example_date ? Carbon::parse($this->resource->example_date)->format('d.m.Y') : null,
            'example_datetime' => $this->resource->example_datetime ? Carbon::parse($this->resource->example_datetime)->format('d.m.Y H:i') : null,
            'example_editor' => $this->resource->example_editor,
            'example_input' => $this->resource->example_input,
            'example_input_file' => $this->resource->getFileLinksBySettings('example_input_file'),
            'example_select' => $this->resource->example_select,
            'example_select_wrap' => $this->getExampleSelectWrap(),
            'example_switcher' => (bool)$this->resource->example_switcher,
            'example_textarea' => $this->resource->example_textarea,
        ];
    }

    private function getExampleSelectWrap(): array|string|null
    {
        if ($this->resource->example_select_wrap) {
            $unprepared = json_decode($this->resource->example_select_wrap);
            $prepared = [];

            foreach ($unprepared as $value) {
                $prepared[] = (int)$value;
            }

            return $prepared;
        }

        return $this->resource->example_select_wrap;
    }
}