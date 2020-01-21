<?php

namespace App\Repositories;

use App\Models\Language;
use App\Traits\Find;

class LanguageRepository
{
    use Find;

    public $model;

    public function __construct(Language $model)
    {
        $this->model = $model;
    }
}