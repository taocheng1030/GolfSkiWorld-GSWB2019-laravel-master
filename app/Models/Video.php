<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $hidden =[
        'updated_at',
        'movieable_id',
        'movieable_type',
        'deleted_at',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function movieable()
    {
        return $this->morphTo();
    }
}
