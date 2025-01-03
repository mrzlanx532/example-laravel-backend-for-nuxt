<?php

namespace App\PanelForms;

use App\Http\Resources\Backoffice\Managers\Manager\ManagerResource;
use App\Models\Managers\Manager;
use Mrzlanx532\LaravelBasicComponents\PanelForm\PanelForm;

class ManagerPanelForm extends PanelForm
{
    protected string $model = Manager::class;
    protected string|null $resource = ManagerResource::class;

    protected function getInputs(): array
    {
        return [];
    }
}