<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backoffice\Users\User\UserForDetailResource;
use App\Models\Users\User;
use App\PanelForms\UserPanelForm;
use App\PanelSet\Users\UserPanelSet;
use App\Services\Users\User\UserCreateService;
use App\Services\Users\User\UserDeleteService;
use App\Services\Users\User\UserDisableService;
use App\Services\Users\User\UserEnableService;
use App\Services\Users\User\UserGenerateXLSXAboutDownloadedSoundContentService;
use App\Services\Users\User\UserPasswordResetService;
use App\Services\Users\User\UserUpdateService;
use Mrzlanx532\LaravelBasicComponents\PanelSet\Exceptions\InvalidJsonFormatForFiltersParameterException;
use Mrzlanx532\LaravelBasicComponents\PanelSet\Exceptions\InvalidPanelSetConfigurationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @group backoffice/users
 * @authenticated
 *
 * __Эндпоинты для пользователей__
 */
class UserController extends Controller
{
    /**
     * GET
     * users/browse
     * [backoffice]
     * Список пользователей
     *
     * @param UserPanelSet $userPanelSet
     * @return JsonResponse
     * @throws InvalidJsonFormatForFiltersParameterException
     * @throws InvalidPanelSetConfigurationException
     * @throws ValidationException
     */
    public function browse(UserPanelSet $userPanelSet): JsonResponse
    {
        return response()->json($userPanelSet->handle());
    }

    /**
     * GET
     * users/detail
     * [backoffice]
     * Детальная пользователя
     *
     * @queryParam id int required
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function detail(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|int'
        ]);

        return response()->json(
            new UserForDetailResource(
                User::query()
                    ->select([
                        'users_users.*',

                        'users_countries.id as users_countries_id',
                        'users_countries.name_ru as users_countries_name_ru',
                        'users_countries.name_en as users_countries_name_en',

                        'users_company_business_types.id as users_company_business_types_id',
                        'users_company_business_types.name_en as users_company_business_types_name_en',
                        'users_company_business_types.name_ru as users_company_business_types_name_ru',
                    ])
                    ->leftJoin('users_company_business_types', 'users_company_business_types.id', 'users_users.company_business_type_id')
                    ->leftJoin('users_countries', 'users_countries.id', 'users_users.company_country_id')
                    ->where('users_users.id', $request->get('id'))
                    ->firstOrFail()
            )
        );
    }

    /**
     * POST
     * users/delete
     * [backoffice]
     * Удаление пользователя
     *
     * @bodyParam id int required
     *
     * @param Request $request
     * @param UserDeleteService $userDeleteService
     * @return JsonResponse
     * @throws ValidationException
     */
    public function delete(Request $request, UserDeleteService $userDeleteService): JsonResponse
    {
        $userDeleteService->setParams($request)->handle();

        return response()->json(['status' => true]);
    }

    /**
     * POST
     * users/create
     * [backoffice]
     * Создание пользователя
     *
     * @bodyParam first_name string required
     * @bodyParam last_name string required
     * @bodyParam email string required
     * @bodyParam phone string required
     * @bodyParam description string
     * @bodyParam picture string
     * @bodyParam company_name string required
     * @bodyParam company_address string required
     * @bodyParam company_index string required
     * @bodyParam company_country_id int required
     * @bodyParam company_city string required
     * @bodyParam is_agree bool required
     * @bodyParam description string
     * @bodyParam picture file
     * @bodyParam password string required
     * @bodyParam password_confirmation string required
     * @bodyParam subscription_till string. Example: "02.02.2023"
     * @bodyParam subscription_till_for_exclusive_tracks string. Example: "02.02.2023"
     * @bodyParam subscription_type_id string. Example: "NONE"
     * @bodyParam company_url string
     * @bodyParam job_title string required
     * @bodyParam about string
     * @bodyParam company_business_type_id int required
     * @bodyParam locale_id string required
     * @bodyParam is_checked bool required
     * @bodyParam content string
     *
     * @param Request $request
     * @param UserCreateService $userCreateService
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request, UserCreateService $userCreateService): JsonResponse
    {
        $userCreateService->setParams($request)->handle();

        return response()->json(['status' => true]);
    }

    /**
     * GET
     * users/form
     * [backoffice]
     * Форма создания\обновления пользователя
     *
     * @queryParam id int
     *
     * @param UserPanelForm $userPanelForm
     * @return JsonResponse
     */
    public function form(UserPanelForm $userPanelForm): JsonResponse
    {
        return response()->json($userPanelForm->get());
    }

    /**
     * POST
     * users/update
     * [backoffice]
     * Обновление пользователя
     *
     * @bodyParam id int required
     * @bodyParam first_name string required
     * @bodyParam last_name string required
     * @bodyParam email string required
     * @bodyParam phone string required
     * @bodyParam company_country_id int required
     * @bodyParam company_city string required
     * @bodyParam company_address string required
     * @bodyParam company_index string required
     * @bodyParam company_name string required
     * @bodyParam description string
     * @bodyParam picture file
     * @bodyParam subscription_till string. Example: "21.02.2023"
     * @bodyParam subscription_till_for_exclusive_tracks string. Example: "02.02.2023"
     * @bodyParam subscription_type_id string
     * @bodyParam company_url string
     * @bodyParam job_title string required
     * @bodyParam about string
     * @bodyParam company_business_type_id int required
     * @bodyParam locale_id string required
     * @bodyParam content string
     *
     * @param Request $request
     * @param UserUpdateService $userUpdateService
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, UserUpdateService $userUpdateService): JsonResponse
    {
        $userUpdateService->setParams($request)->handle();

        return response()->json(['status' => true]);
    }

    /**
     * POST
     * users/password-reset
     * [backoffice]
     * Сбросить пароль пользователя
     *
     * @bodyParam id int required
     *
     * @param Request $request
     * @param UserPasswordResetService $userPasswordResetService
     * @return JsonResponse
     * @throws ValidationException
     */
    public function passwordReset(Request $request, UserPasswordResetService $userPasswordResetService): JsonResponse
    {
        $userPasswordResetService->setParams($request)->handle();

        return response()->json(['status' => true]);
    }

    /**
     * POST
     * users/disable
     * [backoffice]
     * Заблокировать пользователя
     *
     * @bodyParam id int required
     *
     * @param Request $request
     * @param UserDisableService $userDisableService
     * @return JsonResponse
     * @throws ValidationException
     */
    public function disable(Request $request, UserDisableService $userDisableService): JsonResponse
    {
        $userDisableService->setParams($request)->handle();

        return response()->json(['status' => true]);
    }

    /**
     * POST
     * users/enable
     * [backoffice]
     * Разблокировать пользователя
     *
     * @bodyParam id int required
     *
     * @param Request $request
     * @param UserEnableService $userEnableService
     * @return JsonResponse
     * @throws ValidationException
     */
    public function enable(Request $request, UserEnableService $userEnableService): JsonResponse
    {
        $userEnableService->setParams($request)->handle();

        return response()->json(['status' => true]);
    }
}