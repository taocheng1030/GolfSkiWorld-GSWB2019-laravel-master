<?php
namespace App\Traits;

use Validator;
use FFMpeg\FFProbe;
use Illuminate\Http\Request;
use Dingo\Api\Exception\ValidationHttpException;

trait Validation
{
    public function validateApi(Request $request, $model, $messages = [])
    {
        $this->make($request->all(), $this->validateRules(), $messages);

        if (empty($this->validateQuery($request))) {
            return false;
        }

        $className = get_class($model);
        $exists = $className::where($this->validateQuery($request))->first();

        if ($exists && $model->id && ($exists->id != $model->id)) {
            throw new ValidationHttpException($this->response->error('name is already taken and registered', 500));
        }

        if ($exists && !$model->id) {
            throw new ValidationHttpException($this->response->error('name is already taken and registered', 500));
        }

        return false;
    }

    private function validateCredentials(Request $request, $rules, $messages = [])
    {
        $credentials = [];
        foreach ($request->all() as $key => $value) {
            if (array_key_exists($key, $rules))
                $credentials[$key] = $value;
        }

        $this->make($credentials, $rules, $messages);

        return $credentials;
    }

    protected function make($request, $rules, $messages = [])
    {
        $validator = Validator::make($request, $rules, $messages);
        if ($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }
    }

    public static function makeValidateCredentials(Request $request, $rules, $messages = [])
    {
        $validator = new self();
        return $validator->validateCredentials($request, $rules, $messages);
    }
}