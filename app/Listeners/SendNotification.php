<?php

namespace App\Listeners;

use App\Events\NotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EventNotification;

class SendNotification implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param  \App\Events\NotificationEvent  $event
     * @return void
     */
    public function handle(NotificationEvent $event)
    {
        Notification::send($event->users, new EventNotification($event->event));
    }

}
