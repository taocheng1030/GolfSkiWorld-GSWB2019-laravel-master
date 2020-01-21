<?php

namespace App\Models;

use App\Traits\Filter;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use \App\Traits\Model, Filter;

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'short',
        'local',
    ];

    protected $sortable = [
        'name',
        'short',
        'local',
    ];

    protected $searchable = [
        'name',
        'short',
        'local',
    ];

    public function getTranslateAttribute()
    {
        return DIRECTORY_SEPARATOR . 'translations'. DIRECTORY_SEPARATOR . $this->local;
    }

    public function getIconAttribute()
    {
        return config('photo.flag.path') . $this->local . config('photo.flag.ext');
    }

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }
}
