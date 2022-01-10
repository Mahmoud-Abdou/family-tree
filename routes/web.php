<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware(['auth'])->name('home');

Route::get('/test', function () {

    dump(Helper::getBrowser());
    dump(Helper::getOS());
    $user = auth()->user();
    dump($user);
    dump(request()->ip());
    dump(request()->header('user-agent'));
    dd(app()->getLocale());

});
