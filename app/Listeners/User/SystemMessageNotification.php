<?php

namespace App\Listeners\User;

use App\Events\User\BookedEvent;
use App\Repositories\SystemRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SystemMessageNotification implements ShouldQueue
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
     * @param  BookedEvent  $event
     * @return void
     */
    public function handle(BookedEvent $event)
    {
        $model = $this->repository->model;
        $this->repository->type = $model::TYPE_NOTIFICATION;
        $model = $model::create([
            'messageable_id' => $event->user->id,
            'messageable_type' => get_class($event->user),
            'type' => $this->repository->type,
            'message' => trans('system.notification.user.booking', [
                'name' => $event->user->name,
                'deal' => $event->model->name,
                'user_url' => adminUrl($event->user->getModelName(true, true), ['id' => $event->user->id, 'edit']),
                'deal_url' => adminUrl($event->model->getModelName(true, true), ['id' => $event->model->id, 'edit']),
            ]),
        ]);

        publish_notification([
            'event' => 'booking',
            'data' => [
                'total' => $this->repository->getTotal(),
                'header' => $this->repository->getHeader(),
                'message' => view('layouts.admin.header.notifications-item', ['notification' => $model])->render(),
            ]
        ]);
    }
}
