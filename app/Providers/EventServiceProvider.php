<?php

namespace App\Providers;

use App\Events\LogedUser;
use App\Events\RegisteredUser;
use App\Listeners\AssignDefaultPermission;
use App\Listeners\UserLogedNotification;
use App\Listeners\UserRegisteredNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        LogedUser::class => [
//            AssignDefaultPermission::class,
            UserLogedNotification::class,
        ],
        RegisteredUser::class => [
            AssignDefaultPermission::class,
            UserRegisteredNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
