<?php

use App\Http\Controllers\Backoffice\ManagerController;
use App\Http\Controllers\Backoffice\UserController;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Route;

Route::get('common/definitions', [CommonController::class, 'getAvailableDefinitions']);

Route::post('managers/self/auth', [ManagerController::class, 'auth']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('managers/browse', [ManagerController::class, 'browse']);
    Route::get('managers/detail', [ManagerController::class, 'detail']);
    Route::get('managers/form', [ManagerController::class, 'form']);
    Route::post('managers/delete', [ManagerController::class, 'delete']);
    Route::post('managers/create', [ManagerController::class, 'create']);
    Route::post('managers/update', [ManagerController::class, 'update']);

    Route::get('managers/self/detail', [ManagerController::class, 'selfDetail']);
    Route::post('managers/self/logout', [ManagerController::class, 'logout']);

    Route::get('users/browse', [UserController::class, 'browse']);
    Route::get('users/detail', [UserController::class, 'detail']);
    Route::get('users/form', [UserController::class, 'form']);
    Route::post('users/create', [UserController::class, 'create']);
    Route::post('users/update', [UserController::class, 'update']);
    Route::post('users/delete', [UserController::class, 'delete']);
    Route::post('users/password-reset', [UserController::class, 'passwordReset']);
    Route::post('users/disable', [UserController::class, 'disable']);
    Route::post('users/enable', [UserController::class, 'enable']);
    Route::get('users/downloaded-content-get-xlsx', [UserController::class, 'downloadedContentGenerateXLSX']);
    Route::get('users/reports/browse', [UserController::class, 'usersReportsBrowse']);
    Route::get('users/reports/detail', [UserController::class, 'usersReportsDetail']);
    Route::post('users/reports/delete', [UserController::class, 'usersReportsDelete']);
});