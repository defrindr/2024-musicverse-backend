<?php

use App\Http\Controllers\ExampleController;
use App\Modules\Auth\Controllers\AuthController;
use App\Modules\Clinic\Controllers\AnimalTypeController;
use App\Modules\Clinic\Controllers\DrugController;
use App\Modules\Web\Controllers\WebConfigController;
use Illuminate\Support\Facades\Route;

Route::get('/dropdown', [ExampleController::class, 'dropdown']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});

Route::group([
    // 'middleware' => 'auth:sanctum'
], function () {
    Route::get('/web-config', [WebConfigController::class, 'index'])->name('web-config.index');
    Route::put('/web-config', [WebConfigController::class, 'update'])->name('web-config.update');
    Route::post('/web-config/image', [WebConfigController::class, 'updateImage'])->name('web-config.update-image');

    Route::resource('/animal-type', AnimalTypeController::class);
    Route::resource('/drug', DrugController::class);
});
