<?php
namespace App\Traits;

use Redirect;
use Illuminate\Http\Request;

trait Resource
{
    /*
     * Controller resource actions
     */

    public function index()
    {
        if ($this->isApiController()) {
            return array_merge([
                $this->modelName(true, true) => $this->find()
            ], $this->withModels());
        } else {
            return $this->view('index', [
                'models' => $this->find()
            ]);
        }
    }

    public function filter($site)
    {
        return array_merge([
            $this->modelName(true, true) => $this->find(['site_id' => $site])
        ], $this->withModels());
    }

    public function show($id)
    {
        return $this->view('show', [
            'model' => $this->find($id)
        ]);
    }

    public function create()
    {
        return $this->view(
            'create',
            $this->withModels()
        );
    }

    public function edit($id)
    {
        if ($this->isApiController()) {
            return array_merge([
                $this->modelName() => $this->find($id),
            ], $this->withModels());
        } else {
            return $this->view(
                'edit',
                array_merge([
                    'model' => $this->find($id),
                ], $this->withModels())
            );
        }
    }

    public function store(Request $request)
    {
        $model = new $this->model;
        $this->save($request, $model);

        if ($this->isApiController()) {
            return ['success' => true, 'message' => 'data successfully was saved'];
        } else {
            return false;
        }
    }

    public function update(Request $request, $id)
    {
        $model = $this->find($id);
        $this->save($request, $model);

        if ($this->isApiController()) {
            return ['success' => true, 'message' => 'data successfully was saved'];
        } else {
            return false;
        }
    }

    public function destroy(Request $request, $id)
    {
        $this->find($id)->delete();

        if ($request->ajax()) {
            return statusTrue();
        }

        return Redirect::to(adminUrl($this->controllerName()));
    }

    public function delete($id)
    {
        $model = $this->find($id)->delete();
        if ($model)
            return ['success' => $model];
        else
            abort(404, $this->modelName(false) . ' not found');
    }

    public function booked($id)
    {
        $model = $this->find($id);
        if (isset($model->bookings))
            return statusTrue([
                'title' => 'Members',
                'message' => view('admin.user.members', ['model' => $model])->render()
            ]);
    }


    /*
     * Manage models
     */

    public function getClassModel($model)
    {
        $classes = [
            \App\User::class,
            \App\Models\Deal::class,
            \App\Models\Lastminute::class,
            \App\Models\Destination::class,
            \App\Models\Accommodation::class,
            \App\Models\Restaurant::class,
            \App\Models\Resort::class,
            \App\Models\Awardinfo::class,
            \App\Models\About::class,
            \App\Models\Destinfo::class,
            \App\Models\Article::class,
            \App\Models\Site::class
        ];

        $models = array_map(function ($item) {
            $modelName = class_basename($item);
            return str_plural(strtolower($modelName));
        }, $classes);

        if (!in_array($model, $models)) {
            return $this->response->error('Model not specified', 500);
        }

        return $classes[array_search($model, $models)];
    }
}
