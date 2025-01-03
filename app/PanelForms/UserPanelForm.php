<?php

namespace App\PanelForms;

use App\Definitions\LocaleDefinition;
use App\Definitions\Users\User\StateDefinition;
use App\Definitions\Users\User\SubscriptionTypeDefinition;
use App\Http\Resources\Backoffice\Users\User\UserForFormResource;
use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\PanelForm\PanelForm;

class UserPanelForm extends PanelForm
{
    protected string $model = User::class;
    protected string|null $resource = UserForFormResource::class;

    protected function getInputs(): array
    {
        return [
            'subscription_types' => SubscriptionTypeDefinition::getItems(),
            'states' => StateDefinition::getItems(),
            'locales' => LocaleDefinition::getItems(),
        ];
    }
}