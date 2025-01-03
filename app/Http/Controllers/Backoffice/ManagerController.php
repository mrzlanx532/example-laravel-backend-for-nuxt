<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backoffice\Managers\Manager\ManagerResource;
use App\Models\Managers\Manager;
use App\PanelForms\ManagerPanelForm;
use App\PanelSet\ManagerPanelSet;
use App\Services\Managers\Manager\ManagerAuthService;
use App\Services\Managers\Manager\ManagerCreateService;
use App\Services\Managers\Manager\ManagerDeleteService;
use App\Services\Managers\Manager\ManagerLogoutService;
use App\Services\Managers\Manager\ManagerUpdateService;
use Mrzlanx532\LaravelBasicComponents\PanelSet\Exceptions\InvalidJsonFormatForFiltersParameterException;
use Mrzlanx532\LaravelBasicComponents\PanelSet\Exceptions\InvalidPanelSetConfigurationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @group backoffice/managers
 * __Эндпоинты для менеджеров__
 */
class ManagerController extends Controller
{
    /**
     * GET
     * managers/browse
     * [backoffice]
     * Браузер менеджеров
     *
     * @authenticated
     *
     * @param ManagerPanelSet $managerPanelSet
     * @return JsonResponse
     * @throws ValidationException
     * @throws InvalidJsonFormatForFiltersParameterException
     * @throws InvalidPanelSetConfigurationException
     */
    public function browse(ManagerPanelSet $managerPanelSet): JsonResponse
    {
        return response()->json($managerPanelSet->handle());
    }

    /**
     * GET
     * managers/detail
     * [backoffice]
     * Браузер менеджеров
     *
     * @authenticated
     *
     * @queryParam id int required
     */
    public function detail(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|int'
        ]);

        return response()->json(
            new ManagerResource(
                Manager::query()
                    ->where('id', $request->get('id'))
                    ->firstOrFail()
            )
        );
    }

    /**
     * GET
     * managers/form
     * [backoffice]
     * Форма для создания\редактирования менеджера
     *
     * @authenticated
     *
     * @queryParam id int required
     */
    public function form(ManagerPanelForm $managerPanelForm): JsonResponse
    {
        return response()->json($managerPanelForm->get());
    }

    /**
     * POST
     * managers/self/auth
     * [backoffice]
     * Авторизация менеджера
     *
     * @bodyParam email string required
     * @bodyParam password string required
     *
     * @param Request $request
     * @param ManagerAuthService $managerAuthService
     * @return JsonResponse
     * @throws ValidationException
     */
    public function auth(Request $request, ManagerAuthService $managerAuthService): JsonResponse
    {
        return response()->json($managerAuthService->setParams($request)->handle());
    }

    /**
     * GET
     * managers/self/detail
     * [backoffice]
     * Детальная текущего менеджера
     *
     * @authenticated
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function selfDetail(Request $request): JsonResponse
    {
        return response()->json(
            new ManagerResource(
                $request->user()
            )
        );
    }

    /**
     * POST
     * managers/self/logout
     * [backoffice]
     * Логаут
     *
     * @authenticated
     *
     * @param ManagerLogoutService $managerLogoutService
     * @return JsonResponse
     */
    public function logout(ManagerLogoutService $managerLogoutService): JsonResponse
    {
        $managerLogoutService->handle();

        return response()->json(['status' => true]);
    }

    /**
     * POST
     * managers/delete
     * [backoffice]
     * Удаление менеджера
     *
     * @authenticated
     *
     * @bodyParam id int required
     *
     * @param Request $request
     * @param ManagerDeleteService $managerDeleteService
     * @return JsonResponse
     * @throws ValidationException
     */
    public function delete(Request $request, ManagerDeleteService $managerDeleteService): JsonResponse
    {
        $managerDeleteService->setParams($request)->handle();

        return response()->json(['status' => true]);
    }

    /**
     * POST
     * managers/create
     * [backoffice]
     * Создание менеджера
     *
     * @authenticated
     *
     * @bodyParam name string required
     * @bodyParam email string required
     * @bodyParam password string required
     *
     * @param Request $request
     * @param ManagerCreateService $managerCreateService
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request, ManagerCreateService $managerCreateService): JsonResponse
    {
        $managerCreateService->setParams($request)->handle();

        return response()->json(['status' => true]);
    }

    /**
     * POST
     * managers/update
     * [backoffice]
     * Изменение менеджера
     *
     * @authenticated
     *
     * @bodyParam id int required
     * @bodyParam name string required
     * @bodyParam email string required
     * @bodyParam password string
     *
     * @param Request $request
     * @param ManagerUpdateService $managerUpdateService
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, ManagerUpdateService $managerUpdateService): JsonResponse
    {
        $managerUpdateService->setParams($request)->handle();

        return response()->json(['status' => true]);
    }
}
