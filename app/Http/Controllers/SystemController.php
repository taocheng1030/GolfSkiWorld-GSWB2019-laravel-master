<?php

namespace App\Http\Controllers;

use App\Repositories\SystemRepository;
use App\Traits\Additional;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    use Additional;

    public function __construct(SystemRepository $repository, Request $request)
    {
        $this->middleware('auth');
        $this->middleware('moderator');

        $this->request = $request;
        $this->repository = $repository;
    }

    public function markRead()
    {
        if (!is_array($this->request['ids']))
            return statusFalse();

        return [
            'status' => $this->repository->delete($this->request['ids']),
            'total' => $this->repository->getTotal(),
            'header' => $this->repository->getHeader()
        ];
    }
}
