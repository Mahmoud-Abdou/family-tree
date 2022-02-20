<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\Dashboard\DeathController;
use App\Http\Controllers\Dashboard\EventController;
use App\Http\Controllers\Dashboard\MarriageController;
use App\Http\Controllers\Dashboard\NewbornController;
use App\Http\Controllers\Dashboard\NewsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::group(['middleware' => ['permission:dashboard.read|dashboard.update']], function () {
        Route::resource('users', UserController::class)->only(['index', 'show']);
        Route::post('users-activate', [UserController::class, 'activate'])->name('users.activate');
        Route::resource('roles', RoleController::class);
        Route::post('update-role', [UserController::class, 'roleAssign'])->name('users.roleAssign');
        Route::resource('categories', CategoryController::class);
        Route::resource('cities', CityController::class);
        Route::resource('events', EventController::class);
        Route::post('event-activate', [EventController::class, 'activate'])->name('events.activate');
        Route::resource('reports', ReportController::class);
//        Route::resource('families', FamilyController::class);
        Route::resource('deaths', DeathController::class);
        Route::resource('newborns', NewbornController::class);
        Route::resource('marriages', MarriageController::class);
        Route::resource('news', NewsController::class);
        Route::post('news-activate', [NewsController::class, 'activate'])->name('news.activate');
    });

    Route::group(['middleware' => ['role:Super Admin']], function () {
        Route::resource('users', UserController::class)->except(['index', 'show']);
        Route::get('settings', ['\App\Http\Controllers\SettingController', 'show'])->name('settings.show');
        Route::put('settings/update', ['\App\Http\Controllers\SettingController', 'update'])->name('settings.update');
        Route::get('log', ['\App\Http\Controllers\ActivityController', 'index'])->name('log.index');
        Route::get('log-delete', ['\App\Http\Controllers\ActivityController', 'destroy'])->name('log.destroy');
    });

});




