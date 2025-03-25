<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // if roles have Bus module
        Gate::define('isBus', function (User $user) {
            if($user->modules && $user->modules->pluck('module')->contains('bus')){
                return true;
            }
        });
        // if roles have Train module
        Gate::define('isTrain', function (User $user) {
            if($user->modules && $user->modules->pluck('module')->contains('train')){
                return true;
            }
        });
        // if roles have Private module
        Gate::define('isPrivate', function (User $user) {
            if($user->modules && $user->modules->pluck('module')->contains('private')){
                return true;
            }
        });
        // if roles have hiace module
        Gate::define('isHiace', function (User $user) {
            if($user->modules && $user->modules->pluck('module')->contains('hiace')){
                return true;
            }
        });
    }
}
