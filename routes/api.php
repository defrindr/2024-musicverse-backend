<?php

use App\Http\Controllers\ExampleController;
use App\Modules\Audition\Controllers\SkillCategoryController;
use App\Modules\Auth\Controllers\AuthController;
use App\Modules\Web\Controllers\WebConfigController;
use Illuminate\Support\Facades\Route;

Route::get('/dropdown', [ExampleController::class, 'dropdown']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('confirm-role', [AuthController::class, 'confirmRole'])->name('auth.confirm-role');

        Route::get('logout', [AuthController::class, 'logout']);

        // All User
        Route::get('user', [AuthController::class, 'user']);
        Route::put('user', [AuthController::class, 'updateUser']);
        Route::put('password', [AuthController::class, 'updatePassword']);

        Route::get('socials', [AuthController::class, 'social']);
        Route::post('socials', [AuthController::class, 'updateSocial']);
    });
});

Route::middleware('auth:sanctum')->prefix('auditions')->group(function () {
    Route::resource('skill-category', SkillCategoryController::class)->except('update');
    Route::post('skill-category/{id}', [SkillCategoryController::class, 'update'])->name('skill-category.update');
});

Route::group([
    // 'middleware' => 'auth:sanctum'
], function () {
    Route::get('/web-config', [WebConfigController::class, 'index'])->name('web-config.index');
    Route::put('/web-config', [WebConfigController::class, 'update'])->name('web-config.update');
    Route::post('/web-config/image', [WebConfigController::class, 'updateImage'])->name('web-config.update-image');

    // Route::resource('/animal-type', AnimalTypeController::class);
    // Route::resource('/drug', DrugController::class);
});
