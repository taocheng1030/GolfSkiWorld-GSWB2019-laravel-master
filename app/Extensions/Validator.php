<?php

namespace app\Extensions;

use FFMpeg\FFProbe;
use Illuminate\Http\UploadedFile;

class Validator extends \Illuminate\Validation\Validator
{
    /**
     * Restrict upload if video duration more that restricted size
     * @var array $parameters: first element of array - duration in minutes
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validateDuration($attribute, $value, $parameters)
    {
        if (is_string($value)) {
            return true;
        }

        if (stripos(config('video.mimeTypes'), $value->getMimeType()) === false)
            return false;

        $ffProbe = FFProbe::create();
        $duration = $ffProbe->streams($value)->videos()->first()->get('duration');

        return ($duration > $parameters[0]) ? false : true;
    }

}