<?php
namespace App\Traits\Relations;

use Auth;
use App\User;

trait BCLS
{
    /*
    * Booking/Comment/Like/Share relations
    */

    public function bookings()
    {
        return $this->morphToMany(User::class, 'bookable', 'bookings')->with('profile')->whereNull('bookings.deleted_at');
    }

    public function comments()
    {
        return $this->morphToMany(User::class, 'commentable')->with('profile')->whereNull('commentables.deleted_at');
    }

    public function likes()
    {
        return $this->morphToMany(User::class, 'likeable')->with('profile')->whereNull('likeables.deleted_at');
    }

    public function shares()
    {
        return $this->morphToMany(User::class, 'sharing', 'shares')->with('profile')->whereNull('shares.deleted_at');
    }

    public function getIsBookedAttribute()
    {
        $booked = $this->bookings()->whereUserId(Auth::id())->first();
        return (!is_null($booked)) ? true : false;
    }

    public function getIsCommentedAttribute()
    {
        $comment = $this->comments()->whereUserId(Auth::id())->first();
        return (!is_null($comment)) ? true : false;
    }

    public function getIsLikedAttribute()
    {
        $like = $this->likes()->whereUserId(Auth::id())->first();
        return (!is_null($like)) ? true : false;
    }

    public function getIsSharedAttribute()
    {
        $shares = $this->shares()->whereUserId(Auth::id())->first();
        return (!is_null($shares)) ? true : false;
    }
}