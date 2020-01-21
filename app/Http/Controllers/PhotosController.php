<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotosRequest;
use App\Repositories\FileRepository;
use App\Repositories\PhotoRepository;
use App\Traits\Additional;
use Illuminate\Http\Request;

class PhotosController extends Controller
{
    use Additional;

    private $file;

    public function __construct(FileRepository $file, PhotoRepository $repository, Request $request)
    {
        $this->middleware('auth');
        $this->middleware('moderator');

        $this->file = $file;
        $this->file->setRelation('photos'); // name of base relation for model "File" ('photos' or 'videos')

        $this->repository = $repository;
        $this->request = $request;
    }

    public function users()
    {
        return view('admin.photo.index', [
            'controllerUrl' => $this->controllerName(),
            'models' => $this->file->getByRelation('sites')
        ]);
    }

    public function upload(PhotosRequest $request)
    {
        $user = \Auth::user()->toArray();

        if ($request->hasFile('files')) {
            $result = [];
            foreach ($request->file('files') as $file) {
                $photo = \App\Domains\Photo::make($file);
                $photo->save()->uploadS3()->thumbnail()->uploadS3($photo::THUMB)->clear();

                $model = $this->file->create($photo->getParams(), $request->except(['files']));
                if ($model) {
                    $request->user_id = $user['id'];
                    $this->repository->create($request, $model);
                    $html = view('admin.photo.item', ['file' => $model])->render();
                    $files = [
                        'id'     => $model->id,
                        'url'    => $model->file,
                        'thumb'  => $model->thumbnail,
                        'html'   => $html
                    ];
                    $result['files'][] = $files;
                }
            };
            $result['status'] = true;
            error_log(print_r($result, true));
            return $result;
        }

        return ['status' => false];
    }

    public function thumbnail()
    {
        $file = $this->file->find($this->request->get('id'));
        if (is_null($file))
            return ['status' => false];

        $photo = $this->repository->findByKey('file_id', $file->id);
        if (is_null($photo))
            return ['status' => false];

        $this->repository->assignThumbnail($photo);

        $photo->imageable->thumbnail = $file->file;
        $photo->imageable->save();

        return ['status' => true];
    }

    public function delete()
    {
        $file = $this->file->find($this->request->get('id'));
        if (is_null($file))
            return ['status' => false];

        $photo = $this->repository->findByKey('file_id', $file->id);
        if (is_null($photo))
            return ['status' => false];

        $this->repository->clearThumbnail($photo);
        $photo->delete();

        return ['status' => $this->file->delete($file->id)];
    }
}
