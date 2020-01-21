<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destinfo extends Model
{
    use \App\Traits\Model,
        \App\Traits\Localize,
        \App\Traits\Filter;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'description',
        'other_activity',
        'useful_info',
        'thumbnail'
    ];

    public function resorts()
    {
        return $this->belongsToMany(Resort::class)->where("published", true)->withTimestamps();
    }
}
