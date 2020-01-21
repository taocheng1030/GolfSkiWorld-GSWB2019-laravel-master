<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shares extends Model
{
    use SoftDeletes;

    protected $table = 'shares';

    protected $fillable = [
        'user_id',
        'sharing_id',
        'sharing_type',
        'sharing_token',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'sharing_id',
        'sharing_type'
    ];

    public function deals()
    {
        return $this->morphedByMany(Deal::class, 'sharing', 'shares');
    }

    public function lastminutes()
    {
        return $this->morphedByMany(Lastminute::class, 'sharing', 'shares');
    }

    public function accommodations()
    {
        return $this->morphedByMany(Accommodation::class, 'sharing', 'shares');
    }

    public function restaurants()
    {
        return $this->morphedByMany(Restaurant::class, 'sharing', 'shares');
    }

    public function resorts()
    {
        return $this->morphedByMany(Resort::class, 'sharing', 'shares');
    }

    public function files()
    {
        return $this->morphedByMany(File::class, 'sharing', 'shares');
    }

    public function destinations()
    {
        return $this->morphedByMany(Destination::class, 'sharing', 'shares');
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
