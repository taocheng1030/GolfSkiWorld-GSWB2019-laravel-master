<?php
namespace App\Traits;

use JWTAuth;
use Session;
use Redirect;
use App\Domains\Notification;
use Log;

trait Additional
{
    private $token;
    private $model;
    private $request;
    private $repository;
    private $notifications = [];
    private $perPage;

    public function getApiUser()
    {
        $this->user = JWTAuth::toUser($this->token);
        if ($this->user === null) {
            return $this->response->error('User token not specified', 500);
        }

        return $this->user;
    }

    public function find($match = null)
    {
        $model = $this->model;

        if (method_exists($this, 'loadAlways')) {
            $model::with($this->loadAlways());
        }

        $withFilter = [];
        if (method_exists($this, 'withFilterScopes')) {
            $withFilter = $this->withFilterScopes();
        }

        if (is_null($match)) {
            $model = (self::$pagination) ? $model->filter($withFilter, $this->perPage) : $model->get();
        } else {
            $model = (is_array($match)) ? $model->where($match)->get() : $model->find($match);
        }

        if (!$model) {
            abort(404, $this->modelName(false) . ' not found');
        }

        if (method_exists($this, 'loadModels') && !is_array($match)) {
            $model->load($this->loadModels());
        }

        return $model;
    }



    /*
     * Controller universal functions
     */

    private function modelName($lowercase = true, $plural = false)
    {
        $modelName = class_basename(get_class($this->model));
        $modelName = ($lowercase) ? strtolower($modelName) : $modelName;
        $modelName = ($plural) ? str_plural($modelName) : $modelName;
        return $modelName;
    }

    private function controllerName($lowercase = true)
    {
        $className = class_basename(get_class($this));
        $className = substr($className, 0, -10); // -10 = word "Controller"
        $className = ($lowercase) ? strtolower($className) : $className;
        // $className = ($lowercase) ? strtolower(substr($className, 0, 1)).substr($className, 1, strlen($className) - 1) : $className;
        return $className;
    }

    private function isApiController()
    {
        return (stripos($this->controllerName(), 'api') === false) ? false : true;
    }

    private function explodeModels()
    {
        return array_map(function ($item) {
            $modelName = class_basename($item);
            return strtolower($modelName);
        }, $this->models());
    }

    private function view($view, $params)
    {
        $blade = $this->modelName() . '.' . $view;
        return view('admin.' . $blade, array_merge([
            'controllerName' => class_basename(get_class($this)),
            'controllerTitle' => $this->modelName(false, true),
            'controllerUrl' => $this->controllerName()
        ], $params));
    }

    private function redirect($model, $message, $customName = false)
    {
        $link = link_to(adminUrl($this->controllerName() . '/' . $model->id . '/edit'), $customName ? $customName : $model->name);
        $notifications = (empty($this->notifications)) ? '' : implode('. ', $this->notifications);
        Session::flash('message', $this->modelName(false) . ' <b>"' . $link . '"</b> ' . $message . ' ' . $notifications);

        return Redirect::to(adminUrl($this->controllerName()));
    }

    private function sendNotifications($model)
    {
        if ($model->email) {
            $this->notifications[] = Notification::make('mail')->devices($model)->publish();
        }
        if ($model->sms) {
            $this->notifications[] = Notification::make('sms')->devices($model)->publish();
        }
        if ($model->push) {
            $this->notifications[] = Notification::make('push')->devices($model)->publish();
        }

        return $model;
    }



    /*
     * Pagination
     */

    public function enablePagination($perPage = null)
    {
        self::$pagination = true;
        $this->perPage = ($perPage) ? $perPage : config('view.pagination.perPage');
    }
}
