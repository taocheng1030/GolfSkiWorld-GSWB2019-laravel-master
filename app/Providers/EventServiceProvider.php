<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\User\CreateEvent' => [
            'App\Listeners\User\Create\Profile',
            'App\Listeners\User\Create\Email',
        ],
        'App\Events\User\BookedEvent' => [
            'App\Listeners\User\EmailConfirmation',
            'App\Listeners\User\SystemMessageNotification',
        ],
        'App\Events\Video\UploadedEvent' => [
            'App\Listeners\Video\EmailConfirmation',
            'App\Listeners\Video\SystemMessageNotification',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
