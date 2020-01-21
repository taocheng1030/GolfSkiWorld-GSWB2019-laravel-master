<?php

namespace App\Events\Video;

use App\Events\Event;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UploadedEvent extends Event
{
    use SerializesModels;

    public $user;
    public $model;

    public function __construct($user, $model)
    {
        $this->user = $user;
        $this->model = $model;
    }

    public function broadcastOn()
    {
        return [];
    }
}
