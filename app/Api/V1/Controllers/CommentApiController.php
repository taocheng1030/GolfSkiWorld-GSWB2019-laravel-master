<?php

namespace App\Api\V1\Controllers;

use App\Traits\Additional;
use App\Traits\Validation;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class CommentApiController extends Controller
{
    use Helpers, Additional, Validation;

    public function __construct(Request $request)
    {
        $this->middleware('jwt.auth');
        $this->request = $request;
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
            \App\Models\Video::class
        ];
    }

    public function index()
    {
        $response = [];
        foreach ($this->explodeModels() as $model) {
            $model = str_plural($model);
            $relation = 'commented' . $model;
            $response[$model] = $this->user->$relation;
        }
        return $response;
    }

    public function process()
    {
        return $this->handleComment($this->getModel(), $this->request->get('id'), $this->request->get('comment'));
    }

    public function show()
    {
        $model = $this->getModel();
        return [
            'model' => $model::find($this->request->get('id')),
            'comments' => Comment::whereCommentableType($model)->whereCommentableId($this->request->get('id'))->get()
        ];
    }

    public function getModel()
    {
        $request = $this->validateCredentials($this->request, [
            'id'      => 'required|numeric',
            'model'   => 'required|string',
            'comment' => 'sometimes|required|string'
        ]);

        $models = $this->explodeModels();
        if (!in_array($request['model'], $models)) {
            return $this->response->error('Model not specified', 500);
        }

        return $this->models()[array_search($request['model'], $models)];
    }

    public function handleComment($type, $id, $comment)
    {
        $model = Comment::withTrashed()->whereCommentableType($type)->whereCommentableId($id)->whereUserId($this->user->id)->first();

        if (is_null($model)) {
            $model = Comment::create([
                'user_id'          => $this->user->id,
                'commentable_id'   => $id,
                'commentable_type' => $type,
                'commentable_text' => $comment,
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
}
