<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Language;
use App\Models\Site;
use App\Models\Photo;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Save;
use App\Http\Requests\ArticlesRequest;

class ArticlesController extends Controller
{
    use Additional, Resource, Save;

    public function __construct(Article $model)
    {
        $this->middleware('auth');
        $this->middleware('moderator');

        $this->model = $model;

        $this->enablePagination();
    }

    public function edit($id)
    {
        $model = $this->find($id);

        return $this->view('edit', [
            'model' => $model,
            'sites' => Site::all(),
            'languages' => Language::all(),
            'photos' => Photo::where('imageable_type', $this->getClassModel($this->modelName(true, true)))->get(),
        ]);
    }

    public function store(ArticlesRequest $request)
    {
        $model = new $this->model;
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.create.success'));
    }

    public function update(ArticlesRequest $request, $id)
    {
        $model = $this->find($id);
        $model = $this->save($request, $model);

        return $this->redirect($model, trans('dashboard.CRUD.update.success'));
    }

    private function withFilterScopes()
    {
        return [
            'joinSite',
            'joinLanguage'
        ];
    }

    private function withModels()
    {
        return [
            "sites" => Site::all(),
            'languages' => Language::all()
        ];
    }

    private function save(ArticlesRequest $request, Article $model)
    {
        $model->site_id = $request->get('site_id');
        $model->language_id = $request->get('language_id');

        $model->inmenu = $this->boolean($request, 'inmenu');
        $model->startpage = $this->boolean($request, 'startpage');
        $model->published = $this->boolean($request, 'published');

        $model->fill($request->all());
        $model->save();

        return $model;
    }
}
