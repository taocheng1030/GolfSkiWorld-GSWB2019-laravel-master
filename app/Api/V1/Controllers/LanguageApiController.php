<?php

namespace App\Api\V1\Controllers;

use App\Repositories\LanguageRepository;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

class LanguageApiController extends Controller
{
    use Helpers;

    private $repository;

    public function __construct(LanguageRepository $language)
    {
        $this->repository = $language;
    }

    public function index()
    {
        return $this->repository->getAll()->each(function ($row) {
            $row->setAppends(['translate', 'icon']);
        })->toArray();
    }

    public function translations($local)
    {
        $language = $this->repository->findByKey('local', $local);
        if (is_null($language))
            return $this->response->error('Unknown language', 500);

        $translations = [];
        foreach ($language->translations as $translation) {
            $translations[$translation->key] = $translation->translate;
        }

        return $translations;
    }
}
