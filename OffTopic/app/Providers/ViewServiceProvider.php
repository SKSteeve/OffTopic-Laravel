<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('friends',  \App\Http\Controllers\FriendListController::getAllFriends());
        });

        View::composer('*', function ($view) {
            $view->with('notificationsCount', \App\Http\Controllers\NotificationsController::getNotificationsCount());
        });
    }
}
