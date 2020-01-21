<?php
namespace App\Traits;

trait Trash
{
    /*
    * Actions for trash
    */

    public function trash()
    {
        return view('admin.video.trash.index', [
            'controllerUrl' => $this->controllerName(),
            'models' => $this->file->getTrash()
        ]);
    }

    public function trashRestore()
    {
        $status = $this->file->restore($this->request->get('id'));
        return ['status' => $status];
    }

    public function trashDelete()
    {
        $status = $this->file->deleteForever($this->request->get('id'));
        return ['status' => $status];
    }
}