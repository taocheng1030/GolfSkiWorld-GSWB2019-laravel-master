<?php

namespace App\Api\V1\Controllers;

use DB;
use App\Traits\Controllers;
use App\Traits\Validation;
use App\Repositories\FileRepository;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Like;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class TvApiController extends Controller
{
    use Helpers, Validation, Controllers;

    private $file;
    private $request;

    private $perPage;

    public function __construct(FileRepository $video, Request $request)
    {
        $this->file = $video;
        $this->file->perPage = $this->perPage = config('video.perPage');
        $this->file->request = $this->request = $request;
        $this->file->setRelation('videos'); // name of base relation for model "File" ('photos' or 'videos')
    }

    public function sorting()
    {
        return [
            'latest' => 'Latest'
        ];
    }

    public function tv(Request $request)
    {
        $videos = collect();
        $relations = [
            \App\Models\Site::class => 'sites',
        ];

        foreach ($relations as $relation) {
            $videos = $videos->merge($this->file->getByFilter($relation));
        }
        // return $videos;

        $files = $videos;//$this->file->getAll();

        foreach ($files as $m) {
            $likes = Like::select(DB::raw('GROUP_CONCAT(user_id) as users, count(*) as count'))->whereLikeableType(\App\Models\Video::class)->whereLikeableId($m->id)->groupBy('likeable_id')->get()->first();
            if ($likes && $request->userid) {
                $likes->users = explode(",", $likes->users);
                $likes->like = in_array(strval($request->userid), $likes->users);
            }
            $m->likes = $likes;
        }

        return $this->clear($this->paginate($files, $this->perPage)->toArray());
    }

    public function tvFilter(Request $request)
    {
        if (empty($this->request->except('page'))) {
            return $this->response->error('Filter parameters not specified', 500);
        }

        $credentials = $this->validateCredentials($this->request, [
            'country'  => "sometimes|required|numeric",
            'state'  => "sometimes|required|numeric",
            'city'  => "sometimes|required|numeric",
            'category' => "sometimes|required|numeric",
            'name'     => "sometimes|required|string",
            'tags'     => "sometimes|required|string"
        ]);

        if ($this->request->except('page') != $credentials) {
            return $this->response->error('There are unknown parameters', 500);
        }

        $videos = collect();
        $relations = [
            \App\Models\Site::class => 'sites',
        ];

        foreach ($relations as $relation) {
            $videos = $videos->merge($this->file->getByFilter($relation));
        }
        
        foreach ($videos as $m) {
            $likes = Like::select(DB::raw('GROUP_CONCAT(user_id) as users, count(*) as count'))->whereLikeableType(\App\Models\Video::class)->whereLikeableId($m->id)->groupBy('likeable_id')->get()->first();
            if ($likes && $request->userid) {
                $likes->users = explode(",", $likes->users);
                $likes->like = in_array(strval($request->userid), $likes->users);
            }
            $m->likes = $likes;
        }

        return $this->clear($this->paginate($videos, $this->perPage)->toArray());
        
        // foreach ($this->file->allRelations as $relation)
        // {
        //     if ($this->request->has('category') && in_array($relation, $this->file->excludedCategory)) {
        //         continue;
        //     }

        //     if (($this->request->has('country') || $this->request->has('state') || $this->request->has('city')) && in_array($relation, $this->file->excludedDestination)) {
        //         continue;
        //     }

        //     $videos = $videos->merge($this->file->getByFilter($relation));
        // }

        // return $this->clear($this->paginate($videos, $this->perPage)->toArray());
    }
}
