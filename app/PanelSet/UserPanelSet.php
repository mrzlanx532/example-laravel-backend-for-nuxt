<?php

namespace App\PanelSet\Users;

use App\Http\Resources\Backoffice\Users\User\UserForBrowseResource;
use App\Models\Users\User;
use Mrzlanx532\LaravelBasicComponents\PanelSet\Filters\InputFilter;
use Mrzlanx532\LaravelBasicComponents\PanelSet\PanelSet;

class UserPanelSet extends PanelSet
{
    protected string $model = User::class;
    public string $resource = UserForBrowseResource::class;
    public string $browserId = 'users_users';

    public array $fieldsForDefaultSearchFilter = ['first_name', 'last_name', 'email', 'phone', 'company_name'];

    protected array $defaultOrderBy = [
        'created_at' => 'desc',
    ];

    public array $availableOrderBy = [
        'id',
        'created_at',
        'company_name',
        'subscription_till',
    ];

    protected function setFilters()
    {
        /*$this->filtersManager->add(SelectFilter::class, 'state_id', 'Статус', function (SelectFilter $selectFilter) {
            $selectFilter->setOptions(StateDefinition::getItems(false));
            $selectFilter->multiple();
        });*/

       /* $this->filtersManager->add(SelectSearchFilter::class, 'id', 'Имя', function (SelectSearchFilter $selectSearchFilter) {
            $selectSearchFilter->setOptions(User::query()->select('id', 'name as title')->get()->toArray());
            $selectSearchFilter->multiple();
        });

        $this->filtersManager->add(SelectSearchFilter::class, 'subscription_type_id', 'Тип подписки', function (SelectSearchFilter $selectFilter) {
            $selectFilter->setOptions(SubscriptionTypeDefinition::getItems(false));
        });

        $this->filtersManager->add(DateFilter::class, 'created_at', 'Дата создания', function (DateFilter $dateFilter) {
            $dateFilter->range();
        });*/

        /*$this->filtersManager->add(BooleanFilter::class, 'is_read', 'Прочитано?', function (BooleanFilter $booleanFilter) {
        });*/

        $this->filtersManager->add(InputFilter::class, 'company_business_type_id', 'Company business type id', function (InputFilter $inputFilter) {
            $inputFilter->range();
        });
    }
}