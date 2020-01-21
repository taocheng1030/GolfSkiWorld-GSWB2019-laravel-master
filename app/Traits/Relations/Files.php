<?php
namespace App\Traits\Relations;

use App\Models\File;

trait Files
{
    /*
    * Photo/Video relations
    */

    public function photos()
    {
        return $this->morphToMany(File::class, 'imageable', 'photos')
            ->withPivot('thumbnail')
            ->whereNull('photos.deleted_at')
            ->orderBy('created_at', SORT_DESC);
    }

    public function videos()
    {
        return $this->morphToMany(File::class, 'movieable', 'videos')
            ->withPivot(['id', 'awarded', 'promo'])
            ->whereNull('videos.deleted_at')
            ->orderBy('created_at', SORT_DESC);
    }
}