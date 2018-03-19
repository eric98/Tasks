<?php

namespace App\Listeners;

use App\Events\RegisteredUser;
use App\Mail\HelloUser;
use Illuminate\Support\Facades\Mail;

class UserRegisteredNotification
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
        $hellouser = new HelloUser($event->user);
        Mail::to($event->user)->send($hellouser);
    }
}
