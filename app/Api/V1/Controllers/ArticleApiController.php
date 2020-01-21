<?php

namespace App\Api\V1\Controllers;

use DB;
use App\Traits\Controllers;
use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Validation;
use App\Traits\Save;
use App\Models\Article;
use App\Models\Language;
use App\Models\Site;
use App\Models\Like;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Dingo\Api\Routing\Helpers;

class ArticleApiController extends Controller
{
    use Helpers, Additional, Resource, Validation, Save, Controllers;

    public function __construct(Article $article)
    {
        // $this->middleware('jwt.auth');
        $this->model = $article;
    }

    public function index(Request $request)
    {
        $model = $this->model;
        if ($request->inmenu) {
            $model = $model->where('inmenu', $request->inmenu);
        }
        if ($request->startpage) {
            $model = $model->where('startpage', $request->startpage);
        }
        if ($request->published) {
            $model = $model->where('published', $request->published);
        }
        // $models = $model->get()->toArray();
        $models = $model->get();
        foreach ($models as $m) {
            $likes = Like::select(DB::raw('GROUP_CONCAT(user_id) as users, count(*) as count'))->whereLikeableType(\App\Models\Article::class)->whereLikeableId($m->id)->groupBy('likeable_id')->get()->first();
            if ($likes && $request->userid) {
                $likes->users = explode(",", $likes->users);
                $likes->like = in_array(strval($request->userid), $likes->users);
            }
            $m->likes = $likes;
        }


        return $models->toArray();
    }

    private function validateQuery(Request $request)
    {
        return ['site_id' => $request->get('site'), 'language_id' => $request->get('language'), 'name' => $request->get('name')];
    }

    private function validateRules()
    {
        return [
            'site'       => 'required|numeric',
            'language'   => 'required|numeric',
            'name'       => 'required',
            'textinmenu' => 'required',
            'summary'    => 'required',
            'body'       => 'required',
            'tags'       => 'required',
            'link'       => 'required',
        ];
    }

    private function loadModels()
    {
        return ['site', 'language'];
    }

    private function withModels()
    {
        return [
            "sites" => Site::all(),
            'languages' => Language::all()
        ];
    }

    private function save(Request $request, Article $model)
    {
        $this->validateApi($request, $model);

        $model->site_id = Input::get('site');
        $model->language_id = Input::get('language');

        $model->inmenu = $this->boolean($request, 'inmenu');
        $model->startpage = $this->boolean($request, 'startpage');
        $model->published = $this->boolean($request, 'published');

        $model->fill($request->all());
        $model->save();

        return $model;
    }
}
