<?php

namespace App\Events\User;

use App\Events\Event;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateEvent extends Event
{
    use SerializesModels;

    public $user;
    public $data;
    public $mail;

    public function __construct(User $user, array $data = [], $mail = false)
    {
        $this->user = $user;
        $this->data = $data;
        $this->mail = $mail;
    }

    public function broadcastOn()
    {
        return [];
    }
}
