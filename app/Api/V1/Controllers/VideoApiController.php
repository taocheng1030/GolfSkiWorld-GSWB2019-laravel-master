<?php

namespace App\Api\V1\Controllers;

use App\Domains\Video;
use App\Traits\Controllers;
use App\Traits\Validation;
use App\Repositories\FileRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class VideoApiController extends Controller
{
    use Helpers, Validation, Controllers;

    private $file;
    private $request;

    private $perPage;

    public function __construct(FileRepository $video, Request $request)
    {
        $this->middleware('jwt.auth', ['only' => ['upload', 'shared', 'uploads', 'delete']]);

        $this->file = $video;
        $this->file->perPage = $this->perPage = config('video.perPage');
        $this->file->request = $this->request = $request;
        $this->file->setRelation('videos'); // name of base relation for model "File" ('photos' or 'videos')
    }

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

    public function uploads()
    {
        $id = $this->user->id;
        $videos = collect();
        $relations = [
            \App\Models\Site::class => 'sites',
        ];

        foreach ($relations as $relation) {
            $videos = $videos->merge($this->file->getByFilterRelationValue($relation, 'videos', 'user_id', $id));
        }
        return $this->paginate($videos, $this->perPage)->toArray();
    }

    public function awarded()
    {
        $awarded = $this->file->getChosenByRelation('videos', 'awarded');
        if (is_null($awarded)) {
            return $this->response->errorNotFound('Awarded video not found');
        }

        $awarded = $awarded->toArray();
        $awarded['owner'] = $awarded['videos'][0];
        unset($awarded['videos']);

        return $awarded;
    }

    public function promo()
    {
        $awarded = $this->file->getChosenByRelation('videos', 'promo');
        if (is_null($awarded)) {
            return $this->response->errorNotFound('Promotional video not found');
        }

        $awarded = $awarded->toArray();
        $awarded['owner'] = $awarded['videos'][0];
        unset($awarded['videos']);

        return $awarded;
    }

    public function upload()
    {
        $maxUpload = config('video.max_size');
        $mimeTypes = config('video.mimeTypes');
        $maxDuration = config('video.max_duration');
        $inRelations = implode(',', $this->file->allRelations);

        $rules = [
            'id' => "required|numeric",
            'model' => "required|string|in:{$inRelations}",
            'file' => "required|file|mimetypes:{$mimeTypes}|max:{$maxUpload}|duration:{$maxDuration}",
            'description' => "sometimes|required|string",
            'location' => "sometimes|required|string",
        ];

        $messages = [
            'duration' => "Video duration must not exceed {$maxDuration} seconds",
            'mimetypes' => 'Incorrect file type'
        ];

        $this->validateCredentials($this->request, $rules, $messages);

        if ($this->request->hasFile('file')) {
            $request = array_merge($this->request->except(['file']), [
                'user' => ($this->user ? $this->user->toArray() : null)
            ]);

            $video = Video::make($this->request->file('file'), $request);
            $video->save()->publishToQueue();

            return statusTrue([
                'message' => 'Your file is added to upload queue. You will be notified when upload will be completed.'
            ]);
        }
    }

    public function queueDownload($file)
    {
        Video::$load = false;
        return Video::make($file, $this->request, 'queue')->download();
    }

    public function queueDelete($file)
    {
        Video::$load = false;
        return Video::make($file, $this->request, 'queue')->delete();
    }

    public function delete($id)
    {
        $status = $this->file->delete($id);
        return ['status' => $status];
    }
}
