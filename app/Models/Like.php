<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use SoftDeletes;

    protected $table = 'likeables';

    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'likeable_id',
        'likeable_type'
    ];

    public function deals()
    {
        return $this->morphedByMany(Deal::class, 'likeable');
    }

    public function lastminutes()
    {
        return $this->morphedByMany(Lastminute::class, 'likeable');
    }

    public function accommodations()
    {
        return $this->morphedByMany(Accommodation::class, 'likeable');
    }

    public function restaurants()
    {
        return $this->morphedByMany(Restaurant::class, 'likeable');
    }

    public function resorts()
    {
        return $this->morphedByMany(Resort::class, 'likeable');
    }

    public function files()
    {
        return $this->morphedByMany(File::class, 'likeable');
    }

    public function destinations()
    {
        return $this->morphedByMany(Destination::class, 'likeable');
    }

    public function photos()
    {
        return $this->morphedByMany(Photo::class, 'likeable');
    }

    public function videos()
    {
        return $this->morphedByMany(Video::class, 'likeable');
    }
    
    public function articles()
    {
        return $this->morphedByMany(Article::class, 'likeable');
    }
}
