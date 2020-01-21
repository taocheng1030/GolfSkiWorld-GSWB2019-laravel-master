<?php

namespace App\Api\V1\Controllers;

use App\Domains\Photo;
use App\Traits\Controllers;
use App\Traits\Validation;
use App\Repositories\FileRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Repositories\PhotoRepository;
use App\Models\Shares;

class PhotoApiController extends Controller
{
    use Helpers, Validation, Controllers;

    private $file;
    private $photo;
    private $request;

    private $perPage;

    public function __construct(FileRepository $file, PhotoRepository $photo, Request $request)
    {
        $this->middleware('jwt.auth', ['only' => ['upload', 'shared']]);

        $this->file = $file;
        $this->file->perPage = $this->perPage = config('photo.perPage');
        $this->file->request = $this->request = $request;
        $this->file->setRelation('photos'); // name of base relation for model "File" ('photos' or 'videos')

        $this->photo = $photo;
    }

    /*
    * Actions
    */

    public function index()
    {
        return  $this->clear($this->file->getAll()->toArray());
    }

    public function shared()
    {
        return $this->clear($this->file->getByRelation('users', $this->user->id)->toArray(), 'data', false);
    }

    public function users($id = null)
    {
        return $this->clear($this->file->getByRelation('users', $id)->toArray(), 'data', $id ? false : 'owner');
    }

    public function share()
    {
        $maxUpload = config('photo.max_size');
        $mimeTypes = config('photo.mimeTypes');
        $inRelations = implode(',', $this->file->allRelations);

        $rules = [
            'id' => "required|numeric",
            'model' => "required|string|in:{$inRelations}",
            'file' => "required|file|mimetypes:{$mimeTypes}|max:{$maxUpload}",
            'description' => "sometimes|required|string",
            'location' => "sometimes|required|string",
        ];

        $request = $this->validateCredentials($this->request, $rules);

        if ($this->request->hasFile('file')) {
            $photo = Photo::make($this->request->file('file'));
            $photo->save()->uploadS3()->thumbnail()->uploadS3($photo::THUMB)->clear();
            $model = $this->file->create($photo->getParams($request), $this->request->except(['file']), $this->user);
            if ($model) {
                // create photo
                $this->request->user_id = $this->user->id;
                $photo_rep = $this->photo->create($this->request, $model);
                return [
                    'id' => $photo_rep->id,
                    'url'   => $model->file,
                    'thumb' => $model->thumbnail
                ];
            }
        }
    }

    public function upload()
    {
        $user = \Auth::user()->toArray();

        $maxUpload = config('photo.max_size');
        $mimeTypes = config('photo.mimeTypes');
        $inRelations = implode(',', $this->file->allRelations);

        //error_log("Called upload");
        $rules = [
            'id' => "required|numeric",
            'model' => "required|string|in:{$inRelations}",
            'file' => "required|file|mimetypes:{$mimeTypes}|max:{$maxUpload}",
            'description' => "string",
            'location' => "string",
        ];

        $request = $this->validateCredentials($this->request, $rules);

        if ($this->request->hasFile('file')) {
            $photo = Photo::make($this->request->file('file'));
            $photo->save()->uploadS3()->thumbnail()->uploadS3($photo::THUMB)->clear();
            $model = $this->file->create($photo->getParams($request), $this->request->except(['file']), $this->user);
            if ($model) {
                // create photo
                $this->request->user_id = $user['id'];
                $photo_rep = $this->photo->create($this->request, $model);
                return [
                    'id' => $photo_rep->id,
                    'url'   => $model->file,
                    'thumb' => $model->thumbnail
                ];
            }
        }
    }
}
