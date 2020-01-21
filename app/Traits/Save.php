<?php
namespace App\Traits;

use App\Models\Localized;
use App\Models\Localization;
use Illuminate\Http\Request;

trait Save
{
    /*
     * Controller "SAVE" functions
    */

    private function boolean(Request $request, $key)
    {
        return ($request->get($key)) ? true : false;
    }

    private function saveLocal($request, $model)
    {
        $localizedFields = [];
        foreach ($model->localizedFields as $item) {
            $localizedFields[$item] = $request->get('local')[$item];
        }

        foreach ($localizedFields as $field => $value) {
            $localized = $model->localize($field)->first();
            if (!$localized) {
                $localized = new Localized();
                $localized->field = $field;
                $localized->value = $value;
                $localized->localized()->associate($model);
            }

            $localized->value = $value;
            $localized->save();
        }
    }

    private function saveRelations($request, $model, $relations, $explode = null)
    {
        foreach ($relations as $relationName)
        {
            $relation = $request->get($relationName);

            if ($explode === null) {
                $relation = ($relation) ? $relation : [];
            } else {
                $relation = ($relation) ? explode($explode, $relation) : [];
            }

            $model->$relationName()->sync($relation);
        }
    }

    private function saveLocalization($request, $model)
    {
        $localizedFields = [];
        foreach ($model->localized as $item) {
            $localizedFields[str_plural($item)] = $request->get(str_plural($item));
        }

        foreach ($localizedFields as $field => $items) {
            foreach ($items as $language => $value)
            {
                $localized = $model->localization($language, str_singular($field))->first();
                if (!$localized) {
                    $localized = new Localization();
                    $localized->language_id = $language;
                    $localized->field = str_singular($field);
                    $localized->value = $value;
                    $localized->localizable()->associate($model);
                }

                $localized->value = $value;
                $localized->save();
            }
        }
    }

    private function saveThumbnail(Request $request, $path, $base64 = false)
    {
        $thumbnail = $request->get('thumbnail_url');

        if ($file = $request->file('thumbnail')) {
            if ($base64 === false) {
                $thumbnail = ImageUploadS3($file, $path);
            } else {
                $thumbnail = ImageUploadS3Base64($file, $path);
            }
        }

        return $thumbnail;
    }

    private function saveMovie(Request $request, $path, $base64 = false)
    {
        $movie = $request->get('movie_url');

        if ($file = $request->file('movie')) {
            if ($base64 === false) {
                $movie = MovieUploadS3($file, $path);
            } else {
                $movie = MovieUploadS3Base64($file, $path);
            }
        }

        return $movie;
    }
}