<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Traits\Find;

class TagRepository
{
    use Find;

    public $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }
}