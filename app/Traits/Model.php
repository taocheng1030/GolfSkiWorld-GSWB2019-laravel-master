<?php
namespace App\Traits;

trait Model
{
    public static $items;
    public static $pivotHidden = [];



    /*
    * Attributes
    */

    public function getModelName($lowercase = true, $plural = false)
    {
        $modelName = class_basename(get_class($this));
        $modelName = ($lowercase) ? strtolower($modelName) : $modelName;
        $modelName = ($plural) ? str_plural($modelName) : $modelName;
        return $modelName;
    }

    public function getModelAttribute()
    {
        return $this->getModelName();
    }

    public function getNameWithSiteAttribute()
    {
        return $this->site->name . ' :: ' . $this->name;
    }

    /*
    * Hide custom fields
    */
    public function toArray()
    {
        $attributes = $this->attributesToArray();
        $attributes = array_merge($attributes, $this->relationsToArray());

        if (!empty(self::$pivotHidden)) {
            foreach (self::$pivotHidden as $field) {
                unset($attributes['pivot'][$field]);
            }
        }

        return $attributes;
    }



    /*
    * STATIC
    */

    public static function getItems()
    {
        if (is_null(self::$items)) {
            self::$items = self::all();
        }
        return self::$items;
    }

    public static function tableName()
    {
        return (new self)->getTable();
    }
}