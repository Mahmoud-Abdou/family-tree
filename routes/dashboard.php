<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

    Route::group(['middleware' => ['permission:dashboard.read|dashboard.update']], function () {
        Route::resource('users', \App\Http\Controllers\UserController::class)->only(['index', 'show']);
        Route::post('users-activate', [\App\Http\Controllers\UserController::class, 'activate'])->name('users.activate');
        Route::resource('cities', \App\Http\Controllers\CityController::class);
        Route::resource('events', \App\Http\Controllers\EventController::class);
        Route::post('event-activate', [\App\Http\Controllers\EventController::class, 'activate'])->name('events.activate');

    });

    Route::group(['middleware' => ['role:Super Admin']], function () {
        Route::resource('users', \App\Http\Controllers\UserController::class)->except(['index', 'show']);
        Route::resource('roles', \App\Http\Controllers\RoleController::class);
        Route::resource('categories', \App\Http\Controllers\CategoryController::class);
        Route::get('settings', ['\App\Http\Controllers\SettingController', 'show'])->name('settings.show');
        Route::put('settings/update', ['\App\Http\Controllers\SettingController', 'update'])->name('settings.update');
        Route::get('log', ['\App\Http\Controllers\ActivityController', 'index'])->name('log.index');
        Route::get('log-delete', ['\App\Http\Controllers\ActivityController', 'destroy'])->name('log.destroy');

//        Route::resource('settings', \App\Http\Controllers\SettingController::class)
//            ->missing(function () {
//                return redirect()->route('settings.edit');
//            });

    });

});




