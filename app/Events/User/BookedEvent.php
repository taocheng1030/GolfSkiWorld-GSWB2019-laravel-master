<?php

namespace App\Events\User;

use App\Events\Event;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BookedEvent extends Event
{
    use SerializesModels;

    public $user;
    public $model;

    public function __construct(User $user, $model)
    {
        $this->user = $user;
        $this->model = $model;
    }

    public function broadcastOn()
    {
        return [];
    }
}
