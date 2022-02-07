<?php

namespace App\Providers;

use App\Listeners\SendNewsNotification;
use App\Listeners\SendDeathNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\NewsEvent;
use App\Events\DeathEvent;

use App\Listeners\SendNotification;
use App\Events\NotificationEvent;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            SendNewUserNotification::class,
        ],
        NewsEvent::class =>[
            SendNewsNotification::class,
        ],
        DeathEvent::class =>[
            SendDeathNotification::class,
        ],
        NotificationEvent::class =>[
            SendNotification::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
