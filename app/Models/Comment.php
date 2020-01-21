<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'commentables';

    protected $fillable = [
        'user_id',
        'commentable_id',
        'commentable_type',
        'commentable_text',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'commentable_id',
        'commentable_type'
    ];

    public function deals()
    {
        return $this->morphedByMany(Deal::class, 'commentable');
    }

    public function lastminutes()
    {
        return $this->morphedByMany(Lastminute::class, 'commentable');
    }

    public function accommodations()
    {
        return $this->morphedByMany(Accommodation::class, 'commentable');
    }

    public function restaurants()
    {
        return $this->morphedByMany(Restaurant::class, 'commentable');
    }

    public function resorts()
    {
        return $this->morphedByMany(Resort::class, 'commentable');
    }

    public function files()
    {
        return $this->morphedByMany(File::class, 'commentable');
    }

    public function destinations()
    {
        return $this->morphedByMany(Destination::class, 'commentable');
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
