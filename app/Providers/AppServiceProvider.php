<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
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

        // add main menu array to all views from config file
        view()->share('appMenu', config('custom.main_menu'));

        if (!Cache::has('setting')) {
            if (Schema::hasTable('settings')) {
                Cache::rememberForever('setting', function() {
                    return DB::table('settings')->first();
                });
            }
        }

        Gate::after(function ($user, $ability) {
            return $user->hasRole('Super Admin'); // this returns boolean
        });

    }
}
