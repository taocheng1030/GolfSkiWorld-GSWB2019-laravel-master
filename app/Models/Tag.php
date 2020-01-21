<?php

namespace App\Models;

use App\Traits\Filter;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Filter;

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'pivot'
    ];

    protected $fillable = [
        'name'
    ];

    protected $sortable = [
        'name',
    ];

    protected $searchable = [
        'name'
    ];

    public function files()
    {
        return $this->morphedByMany(File::class, 'taggable');
    }

    public function photos()
    {
        return $this->morphedByMany(Photo::class, 'taggable');
    }

    public function videos()
    {
        return $this->morphedByMany(Video::class, 'taggable');
    }
}
