<?php

namespace App\Listeners;

use App\Events\DeathEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DeathNotification;

class SendDeathNotification
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
     * @param  \App\Events\DeathEvent  $event
     * @return void
     */
    public function handle(DeathEvent $event)
    {
        Notification::send($event->users, new DeathNotification($event->death));
    }
}
