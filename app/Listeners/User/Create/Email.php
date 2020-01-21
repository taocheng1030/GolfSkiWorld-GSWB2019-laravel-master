<?php

namespace App\Listeners\User\Create;

use App\Events\User\CreateEvent;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Email implements ShouldQueue
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
     * @param  CreateEvent  $event
     * @return mixed
     */
    public function handle(CreateEvent $event)
    {
        if (!$event->mail) return false;

        $user = $event->user;
        $password = $event->data['password'];

        $this->mailer->send('emails.signup', ['user' => $user, 'password' => $password], function (Message $message) use ($user) {
            $message
                ->to($user->email, $user->login)
                ->subject('Register new user')
                ->from(config('mail.from.address'), config('mail.from.name'));
        });
    }
}
