<?php

namespace App\Repositories;

use App\Models\SystemMessage;

class SystemRepository
{
    public $model;
    public $total;
    public $type;

    public function __construct(SystemMessage $model)
    {
        $this->model = $model;
    }

    public function getNotifications()
    {
        $model = $this->model;
        $this->type = $model::TYPE_NOTIFICATION;
        return $this->getByType();
    }

    public function getFiles()
    {
        $model = $this->model;
        $this->type = $model::TYPE_FILE;
        return $this->getByType();
    }

    public function getByType()
    {
        return $this->model->where('type', $this->type)->orderBy('id', 'desk')->get();
    }

    public function delete($ids)
    {
        $model = $this->model->whereIn('id', $ids)->withTrashed()->first();
        if (!$model)
            return false;

        $this->type = $model->type;
        $this->model->whereIn('id', $ids)->where('type', $this->type)->delete();
        return true;
    }

    /*
    * Pair method with getHeader()
    * Always called first
    */
    public function getTotal()
    {
        $this->total = $this->getByType()->count();
        return $this->total ? $this->total : null;
    }

    /*
    * Pair method with getTotal()
    * Always called second
    */
    public function getHeader()
    {
        return ($this->total > 0)
            ? trans_choice('dashboard.header.notifications.total', $this->total, ['total' => $this->total])
            : trans('dashboard.header.notifications.noMessages');
    }
}