<?php

namespace App\Providers;

use Acacha\User\GuestUser;
use App\Observers\TasksObserver;
use App\Task;
use Auth;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::user()) {
                $view->with('user', Auth::user());
            } else {
                // NullObject
                $view->with('user', new GuestUser());
            }
        });

        Task::observe(TasksObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }
}
