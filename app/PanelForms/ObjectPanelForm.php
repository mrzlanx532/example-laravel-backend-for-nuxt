<?php

namespace App\PanelForms;

use App\Http\Resources\Backoffice\Objects\Obj\ObjectResource;
use App\Models\Objects\Obj;
use Mrzlanx532\LaravelBasicComponents\PanelForm\PanelForm;

class ObjectPanelForm extends PanelForm
{
    protected string $model = Obj::class;
    protected string|null $resource = ObjectResource::class;

    protected function getInputs(): array
    {
        return [
            'example_select' => [
                [
                    'id' => 1,
                    'title' => 'Example1',
                ],
                [
                    'id' => 2,
                    'title' => 'Example2'
                ],
            ],
            'example_select_wrap' => [
                [
                    'id' => 1,
                    'title' => 'Value1',
                ],
                [
                    'id' => 2,
                    'title' => 'Value2'
                ],
            ]
        ];
    }
}