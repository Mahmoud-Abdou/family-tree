<?php

use Illuminate\Support\Facades\Route;

Route::view('terms', 'terms')->name('terms');

//Route::group(['middleware' => ['auth']], function () {
Route::middleware(['auth'])->group(function () {

    Route::get('/', [\App\Http\Controllers\HomeController::class, 'home'])->name('home');

    Route::get('about', [\App\Http\Controllers\HomeController::class, 'about'])->name('about');

    Route::get('profile', [\App\Http\Controllers\HomeController::class, 'profile'])->name('profile');


});

Route::fallback(function () {
    return redirect('/');
});




//
//Route::get('/test', function () {
//
//    dump(config('custom.permissions'));
//    $var = Helper::GeneralSettings('family_name_ar');
//    $va2 = Helper::GeneralSettings('app_logo');
//    dump($var);
//    dump($va2);
//    dump(cache()->get('setting'));
//    $user = auth()->user();
//    dump($user);
//    dump(request()->ip());
//    dump(request()->header('user-agent'));
//    dd(app()->getLocale());
//
//});
