<?php

namespace App\Api\V1\Controllers;

use App\Domains\Photo;
use App\Domains\File;
use App\Traits\Controllers;
use App\Traits\Validation;
use App\Repositories\FileRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class FileApiController extends Controller
{
    use Helpers, Validation, Controllers;

    private $file;
    private $request;

    private $perPage;

    public function __construct(FileRepository $file, Request $request)
    {
        $this->file = $file;
        $this->file->perPage = $this->perPage = config('file.perPage');
        $this->file->request = $this->request = $request;
    }

    /*
    * Actions
    */
    public function index()
    {
        return $this->clear($this->file->getAll()->toArray());
    }

    public function shared()
    {
        return $this->clear($this->file->getByRelation('users', $this->user->id)->toArray(), 'data', false);
    }

    public function users($id = null)
    {
        return $this->clear($this->file->getByRelation('users', $id)->toArray(), 'data', $id ? false : 'owner');
    }

    public function upload()
    {
        $maxUpload = config('file.max_size');
        $inRelations = implode(',', $this->file->allRelations);

        $rules = [
            'id' => "required|numeric",
            'model' => "required|string|in:{$inRelations}",
            'file' => "required|file|max:{$maxUpload}",
        ];

        $request = $this->validateCredentials($this->request, $rules);

        if ($this->request->hasFile('file'))
        {
            $file = File::make($this->request->file('file'));
            $file->save()->uploadS3()->clear();

            $model = $this->file->create($file->getParams($request), $this->request->except(['file']), $this->user);
            if ($model) {
                return [
                    'id' => $model->id,
                    'url'   => $model->file
                ];
            }
        }
    }
}
