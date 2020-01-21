<?php
namespace App\Api\V1\Controllers;

use App\Traits\Additional;
use App\Traits\Resource;
use App\Traits\Validation;
use App\Models\SocialInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class SocialInfoApiController extends Controller
{
    use Helpers, Additional, Resource, Validation;

    public function __construct(SocialInfo $socialInfo)
    {
        $this->model = $socialInfo;
    }

    public function store(Request $request)
    {
        $model = new SocialInfo();
        $this->save($request, $model);

        return 'Social data was saved successfully';
    }

    public function update(Request $request, $id)
    {
        $model = $this->find($id);
        $this->save($request, $model);

        return 'Social data was saved successfully';
    }

    private function validateQuery(Request $request)
    {
        return [];
    }

    private function validateRules() {
        return [
            'type'        => 'required',
            'title'       => 'required',
            'description' => 'required',
            'longitude'   => 'required',
            'latitude'    => 'required',
        ];
    }

    private function loadModels()
    {
        return [];
    }

    private function withModels()
    {
        return [];
    }

    private function save(Request $request, SocialInfo $model)
    {
        $this->validateApi($request, $model);

        $model->DestinationID   = $request->input('DestinationID');
        $model->UserID          = $request->input('UserID');
        $model->Comment         = $request->input('Comment');
        $model->Like            = $request->input('Like');
        $model->save();

        return $model;
    }
}
