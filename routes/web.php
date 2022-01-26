<?php

use Illuminate\Support\Facades\Route;

Route::view('terms', 'terms')->name('terms');

//Route::group(['middleware' => ['auth']], function () {
Route::middleware(['auth'])->group(function () {

    Route::get('/', [\App\Http\Controllers\HomeController::class, 'home'])->name('home');
    Route::get('about', [\App\Http\Controllers\HomeController::class, 'about'])->name('about');
    Route::get('profile', [\App\Http\Controllers\Auth\ProfileController::class, 'show'])->name('profile');
    Route::get('profile/update', [\App\Http\Controllers\Auth\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [\App\Http\Controllers\Auth\ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/update-user', [\App\Http\Controllers\Auth\ProfileController::class, 'updateUser'])->name('profile.update-user');
    Route::post('profile/history-delete', [\App\Http\Controllers\Auth\ProfileController::class, 'historyDelete'])->name('history.delete');

    Route::resource('events', \App\Http\Controllers\EventController::class);
    Route::resource('news', \App\Http\Controllers\NewsController::class);

});

Route::fallback(function () {
    return redirect('/');
});
