<?php

namespace App\Http\Controllers;

use App\Domains\Video;
use App\Traits\Additional;
use App\Traits\Trash;
use App\Repositories\FileRepository;
use App\Repositories\TagRepository;
use App\Repositories\VideoRepository;
use App\Http\Requests\VideosRequest;

use Illuminate\Http\Request;

class VideosController extends Controller
{
    use Additional, Trash;

    private $file;
    private $tags;

    public function __construct(FileRepository $file, VideoRepository $repository, Request $request, TagRepository $tags)
    {
        $this->middleware('auth');
        $this->middleware('admin');

        $this->file = $file;
        $this->file->perPage = $this->perPage = 12;
        $this->file->request = $this->request = $request;
        $this->file->setRelation('videos');

        $this->repository = $repository;
        $this->model = $this->file->model;
        $this->tags = $tags;
    }

    public function users()
    {
        return view('admin.video.index', [
            'controllerUrl' => $this->controllerName(),
            'models' => $this->file->getByRelation('sites')
        ]);
    }

    public function gsw()
    {
        return view('admin.video.gsw', [
            'controllerUrl' => $this->controllerName(),
            'models' => $this->file->getByRelation('users')
        ]);
    }


    public function trash()
    {
        return view('admin.video.index', [
            'controllerUrl' => $this->controllerName(),
            'models' => $this->file->getTrash()
        ]);
    }

    public function award()
    {
        return $this->updateChosen('awarded');
    }

    public function promo()
    {
        return $this->updateChosen('promo');
    }

    public function updateChosen($chosen)
    {
        $file = $this->file->find($this->request->get('id'));
        if (is_null($file))
            return ['status' => false];

        $model = $this->repository->model;
        $model::where($chosen, true)->update([$chosen => false]);
        $model::where('file_id', $file->id)->update([$chosen => true]);

        return ['status' => true];
    }

    public function tags()
    {
        $model = $this->repository->find($this->request->get('id'));
        if (is_null($model))
            return ['status' => false];

        if ($this->request->isMethod('get')) {
            $tags = [];
            $assigned = array_column($model->tags->toArray(), 'id');
            foreach ($this->tags->getAll() as $tag) {
                $tags[] = [
                    'id' => $tag->id,
                    'name' => $tag->name,
                    'checked' => in_array($tag->id, $assigned)
                ];
            }

            return [
                'status' => true,
                'title' => 'Tags',
                'name' => 'tags[]',
                'tags' => $tags
            ];
        }

        if ($this->request->isMethod('post')) {
            $tags = [];
            if ($this->request->has('tags') && is_array($this->request->get('tags'))) {
                $tags = $this->request->get('tags');
            }

            return [
                'status' => $model->tags()->sync($tags)
            ];
        }
    }

    public function delete()
    {
        $id = $this->request->get('id');
        
        $model = $this->repository->model;
        $model::where('file_id', $id )->update(['awarded' => false, 'promo' => false]);

        $status = $this->file->delete($id);
        return ['status' => $status];
    }

    public function upload(VideosRequest $request)
    {
        if ($request->hasFile('files')) {
            $response = [];
            foreach ($request->file('files') as $file) {
                $req = array_merge($request->except(['files']), [
                    'user' => \Auth::user()->toArray()
                ]);

                Video::make($file, $req)->save()->publishToQueue();
                $response['files'][] = [
                    'message' => 'Your file is added to upload queue. You will be notified when upload will be completed.'
                ];
            };
            $response['status'] = true;
            return $response;
        }

        return ['status' => false];
    }
}
