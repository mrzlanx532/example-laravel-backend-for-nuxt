<?php

namespace App\Http\Controllers;

use Mrzlanx532\LaravelBasicComponents\Repositories\Definitions\AllDefinitionsRepository;
use Illuminate\Http\JsonResponse;

/**
 * @group common
 * __Эндпоинты общие для всех поддоменов__
 */
class CommonController extends Controller
{
    /**
     * GET
     * common/definitions
     * Получить все дефинижены
     */
    public function getAvailableDefinitions(AllDefinitionsRepository $allDefinitionsRepository): JsonResponse
    {
        return response()->json($allDefinitionsRepository->enableLocale()->get());
    }

    /**
     * GET
     * common/dictionaries
     * Получить все словари
     */
    public function getAvailableDictionaries(): JsonResponse
    {
        return response()->json([]);
    }
}