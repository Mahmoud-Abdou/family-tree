<?php

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\DeathController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MarriageController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NewbornController;
use App\Http\Controllers\NewsCommentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsLikeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;

Route::get('terms', [HomeController::class, 'terms'])->name('terms');

Route::middleware(['auth'])->group(function () {

    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::post('search', [HomeController::class, 'search'])->name('search');
    Route::get('search/{word?}', [HomeController::class, 'search'])->name('search.show');
    Route::get('search/{word}/{result?}', [HomeController::class, 'searchSingle'])->name('search.result');
    Route::get('about', [HomeController::class, 'about'])->name('about');
    Route::get('family-tree', [HomeController::class, 'familyTree'])->name('family.tree');
    Route::get('family-tree/render', [HomeController::class, 'familyTreeRender'])->name('family.tree.render');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('profile/update', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/update-user', [ProfileController::class, 'updateUser'])->name('profile.update-user');
    Route::post('profile/history-delete', [ProfileController::class, 'historyDelete'])->name('history.delete');
    Route::put('profile/family', [UserController::class, 'updateFamily'])->name('user.family');
    Route::put('profile/foster_family', [UserController::class, 'addFosterFamily'])->name('user.foster_family');
    Route::put('profile/new_foster_family', [UserController::class, 'addNewFosterFamily'])->name('user.new_foster_family');

    Route::resource('events', EventController::class);
    Route::resource('news', NewsController::class);
    Route::resource('deaths', DeathController::class);
    Route::resource('newborns', NewbornController::class);
    Route::resource('marriages', MarriageController::class);
    Route::resource('media', MediaController::class);
    Route::get('media_category', [MediaController::class, 'media_category'])->name('media_category');
    Route::get('get_media/{category_id}', [MediaController::class, 'get_media']);
    Route::get('get_news/{category_id}', [NewsController::class, 'get_news']);

    Route::resource('reports', ReportController::class);

    Route::get('read-notification', [HomeController::class, 'read_notification']);

    Route::resource('news_comments', NewsCommentController::class);
    Route::resource('news_likes', NewsLikeController::class);
});

Route::fallback(function () {
    return redirect('/');
});
