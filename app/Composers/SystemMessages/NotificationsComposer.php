<?php

namespace App\Composers\SystemMessages;

use App\Repositories\SystemRepository;
use Illuminate\Contracts\View\View;

class NotificationsComposer
{
    private $repository;

    public function __construct(SystemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function compose(View $view)
    {
        $view->with('notifications', $this->repository->getNotifications());
    }

}