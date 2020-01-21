<?php

namespace App\Api\V1\Controllers;

use App\Repositories\TagRepository;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    use Helpers;

    private $repository;

    public function __construct(TagRepository $tag)
    {
        $this->repository = $tag;
    }

    public function index()
    {
        return $this->repository->getAll()->toArray();
    }
}
