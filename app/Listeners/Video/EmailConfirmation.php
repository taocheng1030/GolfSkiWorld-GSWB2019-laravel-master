<?php

namespace App\Listeners\Video;

use App\Events\Video\UploadedEvent;
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
     * @param  UploadedEvent  $event
     * @return void
     */
    public function handle(UploadedEvent $event)
    {
        if ($event->model === false) {
            $this->mailFailed($event->user);
        } else {
            $this->mailSuccess($event->user, $event->model);
        }
    }

    private function mailSuccess($user, $model)
    {
        $this->mailer->later(5, 'emails.upload.video', ['user' => $user, 'model' => $model], function (Message $message) use ($user) {
            $message
                ->to($user['email'], $user['name'])
                ->subject(config('video.subject.success'))
                ->from(config('video.from.address'), config('video.from.name'));
        });
    }

    private function mailFailed($user)
    {
        $this->mailer->later(5, 'emails.upload.failed', ['user' => $user], function (Message $message) use ($user) {
            $message
                ->to($user['email'], $user['name'])
                ->subject(config('video.subject.failed'))
                ->from(config('video.from.address'), config('video.from.name'));
        });
    }
}
