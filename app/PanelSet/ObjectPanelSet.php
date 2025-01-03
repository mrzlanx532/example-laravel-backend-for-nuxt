<?php

namespace App\PanelSet;

use App\Http\Resources\Backoffice\Objects\Obj\ObjectResource;
use App\Models\Objects\Obj;
use Mrzlanx532\LaravelBasicComponents\PanelSet\PanelSet;

class ObjectPanelSet extends PanelSet
{
    protected string $model = Obj::class;
    public string $resource = ObjectResource::class;
    public string $browserId = 'objects_objects';
}