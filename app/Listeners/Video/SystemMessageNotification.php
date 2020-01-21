<?php

namespace App\Listeners\Video;

use App\Events\Video\UploadedEvent;
use App\Repositories\SystemRepository;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SystemMessageNotification
{
    public $repository;

    /**
     * Create the event listener.
     * @param  SystemRepository  $repository
     */
    public function __construct(SystemRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  UploadedEvent  $event
     * @return void
     */
    public function handle(UploadedEvent $event)
    {
        error_log("Called Upload Event handler");
        $model = $this->repository->model;
        $this->repository->type = $model::TYPE_FILE;
        $model = $model::create([
            'messageable_id' => $event->user['id'],
            'messageable_type' => User::class,
            'type' => $this->repository->type,
            'message' => trans($event->model ? 'system.notification.video.uploaded.success' : 'system.notification.video.uploaded.failed', [
                'name' => $event->user['name']
            ]),
        ]);

        publish_notification([
            'event' => 'uploaded',
            'data' => [
                'total' => $this->repository->getTotal(),
                'header' => $this->repository->getHeader(),
                'message' => view('layouts.admin.header.notifications-item', ['notification' => $model])->render(),
            ]
        ]);
    }
}
