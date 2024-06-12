<?php

use App\Http\Controllers\ExampleController;
use App\Modules\Audition\Controllers\AuditionAssesmentController;
use App\Modules\Audition\Controllers\AuditionController;
use App\Modules\Audition\Controllers\SkillCategoryController;
use App\Modules\Auth\Controllers\AuthController;
use App\Modules\Auth\Controllers\UserController;
use App\Modules\Web\Controllers\WebConfigController;
use Illuminate\Support\Facades\Route;

Route::get('/dropdown', [ExampleController::class, 'dropdown']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('users/{role}', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}/show', [UserController::class, 'show'])->name('users.show');
});

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

Route::prefix('auditions')->group(function () {
    Route::get('skill-category/dropdown', [SkillCategoryController::class, 'dropdown'])->name('skill-category.dropdown');

    Route::middleware('auth:sanctum')->group(function () {
        Route::resource('skill-category', SkillCategoryController::class)->except('create', 'edit', 'update');
        Route::post('skill-category/{id}', [SkillCategoryController::class, 'update'])->name('skill-category.update');

        Route::resource('audition', AuditionController::class)->except('create', 'edit', 'update');
        Route::post('audition/{id}', [AuditionController::class, 'update'])->name('audition.update');

        Route::resource('audition.assesment', AuditionAssesmentController::class)->except('create', 'edit');
    });
});

Route::get('/preferences', [WebConfigController::class, 'preferences'])->name('web-config.preferences');
Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'cms',
    'as' => 'cms.'
], function () {
    Route::get('/config', [WebConfigController::class, 'index'])->name('config.index');
    Route::put('/config', [WebConfigController::class, 'update'])->name('config.update');
    Route::post('/config/image', [WebConfigController::class, 'updateImage'])->name('config.update-image');

});
