<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\NewsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewsNotification;

class SendNewsNotification
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
     * @param  \App\Events\NewsEvent  $event
     * @return void
     */
    public function handle(NewsEvent $event)
    {
        Notification::send($event->users, new NewsNotification($event->news));
    }
}
