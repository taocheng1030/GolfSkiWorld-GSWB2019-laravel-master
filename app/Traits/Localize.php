<?php
namespace App\Traits;

use App\Models\Localized;
use App\Models\Localization;

trait Localize
{
    public function localize($field)
    {
        return $this->morphOne(Localized::class, 'localized')->where('field', $field);
    }

    public function localization($language_id, $field)
    {
        return $this->morphOne(Localization::class, 'localizable')->where('language_id', $language_id)->where('field', $field);
    }

    public function localized()
    {
        return $this->morphMany(Localized::class, 'localized')->whereIn('field', $this->localizedFields);
    }

    public function localizations()
    {
        return $this->morphMany(Localization::class, 'localizable')->whereIn('field', $this->localizedFields);
    }

    public function getLocalizedField($field)
    {
        foreach ($this->localized as $item) {
            if ($item->field == $field) {
                return $item->value;
            }
        }
    }

    public function getLocaleAttribute()
    {
        $localized = [];
        foreach ($this->localizedFields as $localizedField) {
            foreach ($this->localized as $item) {
                if ($item->field == $localizedField) {
                    $localized[$localizedField] = $item->value;
                }
            }
        }

        return $localized;
    }

    public function getLocalizationField($field, $language_id)
    {
        foreach ($this->localizations as $item) {
            if ($item->field == $field) {
                if ($item->language_id == $language_id) {
                    return $item->value;
                }
            }
        }
    }
}