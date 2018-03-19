<?php

namespace App\Listeners;

use App\Events\RegisteredUser;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssignDefaultPermission implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     *
     * @return void
     */
    public function handle(RegisteredUser $event)
    {
        $event->user->assignRole('task-manager');
    }
}
