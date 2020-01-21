<?php
namespace App\Traits;

use Validator;
use Illuminate\Http\Request;

trait SidebarControl
{
    /*
    * Sidebar control function
    */

    public function sidebarAdd(Request $request)
    {
        $model = $this->getSidebarModel($request);
        if (is_null($model))
            return statusFalse();

        $rules = self::$sidebarControl->getFields($model);
        if (is_null($rules))
            return statusFalse();

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return \Response::json(['error' => $validator->errors()->all()], 422);

        $model = new $model;
        $model->fill($request->all());
        $model->save();

        return statusTrue([
            'name' => $model->name,
            'link' => \HTML::tag('a', '<i class="fa fa-times"></i>', ['href' => '#', 'data-id' => $model->id, 'class' => 'action-sidebar-delete'])->toHtml()
        ]);
    }

    public function sidebarDelete(Request $request)
    {
        $model = $this->getSidebarModel($request);
        if (is_null($model))
            return statusFalse();

        $id = $this->getSidebarId($request);
        if (is_null($id))
            return statusFalse();

        $model = $model::find($id);
        $model->delete();

        return statusTrue();
    }

    private function getSidebarId(Request $request)
    {
        return $request->has('id') ? $request->get('id') : null;
    }

    private function getSidebarModel(Request $request)
    {
        return $request->has('model') ? 'App\Models\\' . $request->get('model') : null;
    }
}