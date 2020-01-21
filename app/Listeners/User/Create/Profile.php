<?php

namespace App\Listeners\User\Create;

use App\Events\User\CreateEvent;
use App\Repositories\UserRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Profile
{
    public $repository;

    /**
     * Create the event listener.
     * @param  UserRepository  $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  CreateEvent  $event
     * @return void
     */
    public function handle(CreateEvent $event)
    {
        $this->repository->model = $event->user;
        $this->repository->setProfile($event->data);
        $this->repository->setPremium();
    }
}
