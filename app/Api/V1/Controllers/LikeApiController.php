<?php

namespace App\Api\V1\Controllers;

use DB;
use App\Traits\Additional;
use App\Traits\Validation;
use App\Traits\Controllers;
use App\Models\Like;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Models\File;

class LikeApiController extends Controller
{
    use Helpers, Additional, Validation, Controllers;

    private $perPage;

    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth');
        $this->request = $request;

        $this->perPage = config('file.perPage');
    }

    private function models()
    {
        return [
            \App\Models\Deal::class,
            \App\Models\Lastminute::class,
            \App\Models\Destination::class,
            \App\Models\Accommodation::class,
            \App\Models\Restaurant::class,
            \App\Models\Resort::class,
            \App\Models\File::class,
            \App\Models\Photo::class,
            \App\Models\Video::class,
            \App\Models\Article::class
        ];
    }

    public function index()
    {
        $response = [];
        foreach ($this->explodeModels() as $model) {
            $model = str_plural($model);
            $relation = 'liked' . $model;
            $response[$model] = $this->user->$relation;
        }
        return $response;
    }

    public function process()
    {
        return $this->handleLike($this->getModel(), $this->request->get('id'));
    }

    public function show()
    {
        $model = $this->getModel();

        return [
            'model' => $model::find($this->request->get('id')),
            'likes' => Like::whereLikeableType($model)->whereLikeableId($this->request->get('id'))->get()
        ];
    }

    public function getModel()
    {
        $request = $this->validateCredentials($this->request, [
            'id'      => 'required|numeric',
            'model'   => 'required|string',
        ]);

        $models = $this->explodeModels();
        if (!in_array($request['model'], $models)) {
            return $this->response->error('Model not specified', 500);
        }

        return $this->models()[array_search($request['model'], $models)];
    }

    public function handleLike($type, $id)
    {
        $model = Like::withTrashed()->whereLikeableType($type)->whereLikeableId($id)->whereUserId($this->user->id)->first();

        if (is_null($model)) {
            $model = Like::create([
                'user_id'       => $this->user->id,
                'likeable_id'   => $id,
                'likeable_type' => $type,
            ]);
        } else {
            if (is_null($model->deleted_at)) {
                $model->delete();
            } else {
                $model->restore();
            }
        }

        return ['status' => $model->exists];
    }

    public function hots()
    {
        $model = $this->getModel();

        $likes = Like::select(DB::raw('likeable_id, likeable_type, count(*) as likes'))
            ->whereLikeableType($model)->groupBy('likeable_id')->orderBy('likes', 'DESC')->limit(10)->get();

        foreach ($likes as $like) {
            $like->model = $model::where('id', $like->likeable_id)->first();
        }

        return [
            'hots' => $likes
        ];
    }

    public function videos()
    {

        $model = str_plural('video');
        $relation = 'liked' . $model;
        $videos = $this->user->$relation;
        $files = [];
        foreach ($videos as $video) {
            $video->file = File::where('id', $video->file_id)->first();

            $likes = Like::select(DB::raw('GROUP_CONCAT(user_id) as users, count(*) as count'))->whereLikeableType(\App\Models\Video::class)->whereLikeableId($video->id)->groupBy('likeable_id')->get()->first();
            if ($likes &&  $this->user->id) {
                $likes->users = explode(",", $likes->users);
                $likes->like = in_array(strval($this->user->id), $likes->users);
            }
            $video->likes = $likes;
        }
        return $this->paginate($videos, $this->perPage)->toArray();
    }
}
