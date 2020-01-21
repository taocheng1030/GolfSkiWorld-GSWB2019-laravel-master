<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use \App\Traits\Model;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'marker'
    ];

    public function getMarkerAttribute()
    {
        return config('photo.marker.path') . strtolower($this->name) . config('photo.marker.ext');
    }
}
