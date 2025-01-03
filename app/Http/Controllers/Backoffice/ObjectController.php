<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backoffice\Objects\Obj\ObjectResource;
use App\Models\Objects\Obj;
use App\PanelForms\ObjectPanelForm;
use App\PanelSet\ObjectPanelSet;
use App\Services\Objects\Obj\ObjectCreateService;
use App\Services\Objects\Obj\ObjectDeleteService;
use App\Services\Objects\Obj\ObjectUpdateService;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Mrzlanx532\LaravelBasicComponents\PanelSet\Exceptions\InvalidJsonFormatForFiltersParameterException;
use Mrzlanx532\LaravelBasicComponents\PanelSet\Exceptions\InvalidPanelSetConfigurationException;

class ObjectController extends Controller
{
    /**
     * @param ObjectPanelSet $objectPanelSet
     * @return JsonResponse
     * @throws InvalidJsonFormatForFiltersParameterException
     * @throws InvalidPanelSetConfigurationException
     * @throws ValidationException
     */
    public function browse(ObjectPanelSet $objectPanelSet): JsonResponse
    {
        return response()->json($objectPanelSet->handle());
    }

    public function detail(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|int'
        ]);

        return response()->json(
            new ObjectResource(
                Obj::findOrFail($request->get('id'))
            )
        );
    }

    public function form(ObjectPanelForm $objectPanelForm): JsonResponse
    {
        return response()->json($objectPanelForm->get());
    }

    /**
     * @throws ValidationException
     */
    public function create(Request $request, ObjectCreateService $objectCreateService)
    {
        $objectCreateService->setParams($request)->handle();
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, ObjectUpdateService $objectUpdateService)
    {
        $objectUpdateService->setParams($request)->handle();
    }

    /**
     * @throws ValidationException
     */
    public function delete(Request $request, ObjectDeleteService $objectDeleteService)
    {
        $objectDeleteService->setParams($request)->handle();
    }
}