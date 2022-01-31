<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;

Route::get('terms', [HomeController::class, 'terms'])->name('terms');

Route::middleware(['auth'])->group(function () {

    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('about', [HomeController::class, 'about'])->name('about');
    Route::get('family-tree', [HomeController::class, 'familyTree'])->name('family.tree');
    Route::get('profile', [\App\Http\Controllers\Auth\ProfileController::class, 'show'])->name('profile');
    Route::get('profile/update', [\App\Http\Controllers\Auth\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [\App\Http\Controllers\Auth\ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/update-user', [\App\Http\Controllers\Auth\ProfileController::class, 'updateUser'])->name('profile.update-user');
    Route::post('profile/history-delete', [\App\Http\Controllers\Auth\ProfileController::class, 'historyDelete'])->name('history.delete');

    //Route::resource('events', \App\Http\Controllers\EventController::class);
    Route::resource('news', \App\Http\Controllers\NewsController::class);
    Route::resource('deaths', \App\Http\Controllers\DeathController::class);
    Route::resource('newborns', \App\Http\Controllers\NewbornController::class);
    Route::resource('media', \App\Http\Controllers\MediaController::class);

    Route::get('get_media/{category_id}', [\App\Http\Controllers\MediaController::class, 'get_media']);

    Route::get('events', [\App\Http\Controllers\EventController::class, 'indexUser'])->name('events.index');
    Route::get('events/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');

});

Route::fallback(function () {
    return redirect('/');
});

