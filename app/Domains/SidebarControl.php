<?php

namespace App\Domains;

class SidebarControl
{
    public $controller;
    public $layout = 'layouts.admin.sidebar-control';

    public $models;
    public $fields;
    public $pages;

    public function __construct($controller, $layout)
    {
        $this->controller = $controller;
        $this->layout = $layout;
    }

    public function setModels($models)
    {
        foreach ($models as $model => $params) {
            $this->models[$model] = [
                'model'  => class_basename($model),
                'title'  => $params['title'],
                'fields' => $params['fields'],
                'models' => $model::all(),
                'links'  => [
                    'action' => adminUrl($this->controller.'/sidebar/add'),
                    'delete' => adminUrl($this->controller.'/sidebar/delete'),
                ]
            ];
        }

        return $this;
    }

    public function filterPages($pages = null)
    {
        if ($pages) {
            $this->pages = $pages;
            return $this;
        }

        $success = false;
        foreach ($this->pages as $page) {
            if (str_contains(\Route::current()->getActionName(), $page)) {
                $success = true;
            }
        }

        return $success;
    }

    public function getFields($model)
    {
        return isset($this->models[$model]) ? $this->models[$model]['fields'] : null;
    }

    public static function make($controller, $layout)
    {
        return new SidebarControl($controller, $layout);
    }
}