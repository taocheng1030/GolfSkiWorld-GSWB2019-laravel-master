<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes, \App\Traits\Model;

    const TYPE_IMAGE = 'image';
    const TYPE_PHOTO = 'photo';
    const TYPE_VIDEO = 'video';

    protected static $fileRelation;

    protected $hidden = [
        'updated_at',
        'deleted_at',
        'pivot'
    ];

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'mime',
        'name',
        'path',
        'ext',
        'size',
        'description',
        'location'
    ];

    protected $appends = [
        'file',
        'thumbnail'
    ];

    public function getFileAttribute()
    {
        return $this->path . $this->name . '.' . $this->ext;
    }

    public function getThumbnailAttribute()
    {
        $suffix = ($this->type == self::TYPE_IMAGE || $this->type == self::TYPE_PHOTO)
            ? config('photo.thumbnail.suffix') . '.' . $this->ext
            : config('video.thumbnail.suffix');

        return $this->path . $this->name . '.' . $suffix;
    }

    public function getIsThumbnailAttribute()
    {
        return (isset($this->pivot) && $this->pivot->thumbnail) ? true : false;
    }

    public function getTypeAttribute()
    {
        if (is_null($this->mime))
            return str_singular(self::$fileRelation);

        return str_contains($this->mime, self::TYPE_IMAGE) ? self::TYPE_IMAGE : self::TYPE_VIDEO;
    }

    public function getUserAttribute()
    {
        return (count($this->users) > 0) ? $this->users[0] : null;
    }

    public function getOwnerAttribute()
    {
        if (count($this->users))
            return $this->users[0];

        if (count($this->deals))
            return $this->deals[0];

        if (count($this->lastminutes))
            return $this->lastminutes[0];

        if (count($this->resorts))
            return $this->resorts[0];

        if (count($this->restaurants))
            return $this->restaurants[0];

        if (count($this->accommodations))
            return $this->accommodations[0];
    }

    public function getVideoAttribute()
    {
        return $this->videos[0];
    }


    /*
    * Base relations, need for "FileRepositories"
    */

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function award()
    {
        return $this->hasOne(Award::class);
    }


    /*
    * Morphed relations
    */

    public function setFileRelation($name)
    {
        self::$fileRelation = $name;
    }

    private function getRelationName()
    {
        return ($this->type == self::TYPE_IMAGE || $this->type == self::TYPE_PHOTO) ? 'imageable' : 'movieable';
    }

    private function getRelationTable()
    {
        return ($this->type == self::TYPE_IMAGE || $this->type == self::TYPE_PHOTO) ? 'photos' : 'videos';
    }

    public function deals()
    {
        return $this->morphedByMany(Deal::class, $this->getRelationName(), $this->getRelationTable());
    }

    public function lastminutes()
    {
        return $this->morphedByMany(Lastminute::class, $this->getRelationName(), $this->getRelationTable());
    }

    public function destinations()
    {
        return $this->morphedByMany(Destination::class, $this->getRelationName(), $this->getRelationTable());
    }

    public function accommodations()
    {
        return $this->morphedByMany(Accommodation::class, $this->getRelationName(), $this->getRelationTable());
    }

    public function restaurants()
    {
        return $this->morphedByMany(Restaurant::class, $this->getRelationName(), $this->getRelationTable());
    }

    public function resorts()
    {
        return $this->morphedByMany(Resort::class, $this->getRelationName(), $this->getRelationTable());
    }

    public function users()
    {
        return $this->morphedByMany(User::class, $this->getRelationName(), $this->getRelationTable());
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function awardinfos()
    {
        return $this->morphedByMany(Awardinfo::class, $this->getRelationName(), $this->getRelationTable());
    }

    public function abouts()
    {
        return $this->morphedByMany(About::class, $this->getRelationName(), $this->getRelationTable());
    }

    public function destinfos()
    {
        return $this->morphedByMany(Destinfo::class, $this->getRelationName(), $this->getRelationTable());
    }

    public function sites()
    {
        return $this->morphedByMany(Site::class, $this->getRelationName(), $this->getRelationTable());
    }
    
    public function articles()
    {
        return $this->morphedByMany(Article::class, $this->getRelationName(), $this->getRelationTable());
    }
}
