<?php

namespace App\Listeners\User;

use App\Events\User\BookedEvent;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailConfirmation
{
    public $mailer;

    /**
     * Create the event listener.
     * @param  Mailer  $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  BookedEvent  $event
     * @return void
     */
    public function handle(BookedEvent $event)
    {
        $user = $event->user;
        $model = $event->model;

        $this->mailer->laterOn(config('booking.queue.name'), config('booking.queue.time'), 'emails.booking.user', ['user' => $user, 'model' => $model], function (Message $message) use ($user) {
            $message
                ->from(config('booking.to.address'), config('booking.to.name'))
                ->to($user->email, $user->name)
                ->subject(config('booking.subject.user'));
        });

        $this->mailer->laterOn(config('booking.queue.name'), config('booking.queue.time') * 2 , 'emails.booking.admin', ['user' => $user, 'model' => $model], function (Message $message) use ($user) {
            $message
                ->from(config('booking.from.address'), config('booking.from.name'))
                ->to(config('booking.to.address'), config('booking.to.name'))
                ->subject(config('booking.subject.admin'));
        });
    }
}
