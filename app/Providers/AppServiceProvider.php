<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
//        Schema::defaultStringLength(191);

        if (!Cache::has('setting')) {
            Cache::rememberForever('setting', function () {
                return DB::table('settings')->first();
            });
        }

        Gate::after(function ($user, $ability) {
            return $user->hasRole('Super Admin'); // this returns boolean
        });

    }
}
