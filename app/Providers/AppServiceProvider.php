<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Mobile_Detect;

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

//        // add detect to app
//        app()->singleton('detect', function(){
//            return new Mobile_Detect;
//        });
//
//        // add detect to all views
//        view()->share('detect', app('detect'));

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

        Builder::macro('whereLike', function ($attributes, $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        str_contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $buffer = explode('.', $attribute);
                            $attributeField = array_pop($buffer);
                            $relationPath = implode('.', $buffer);

                            $query->orWhereHas($relationPath, function (Builder $query) use ($attributeField, $searchTerm) {
                                $query->where($attributeField, 'LIKE', "%{$searchTerm}%");
                            });
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    );
                }
            });
            return $this;
        });
    }
}
