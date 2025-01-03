<?php

namespace App\PanelSet;

use App\Http\Resources\Backoffice\Managers\Manager\ManagerResource;
use App\Models\Managers\Manager;
use Mrzlanx532\LaravelBasicComponents\PanelSet\PanelSet;

class ManagerPanelSet extends PanelSet
{
    protected string $model = Manager::class;
    public string $resource = ManagerResource::class;
    public string $browserId = 'managers';

    protected array $defaultOrderBy = [
        'created_at' => 'desc',
    ];
}