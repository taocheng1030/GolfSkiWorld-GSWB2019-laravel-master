<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $hidden =[
        'created_at',
        'updated_at',
        'imageable_id',
        'imageable_type',
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

    public function imageable()
    {
        return $this->morphTo();
    }
}
