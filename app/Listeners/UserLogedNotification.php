<?php

namespace App\Listeners;

use App\Events\LogedUser;
use App\Mail\Hello;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserLogedNotification
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
    public function handle(LogedUser $event)
    {
        $hello = new Hello($event->user);
        Mail::to($event->user)->send($hello);
    }
}
