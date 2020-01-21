<?php

namespace App;

use App\Models\Accommodation;
use App\Models\Deal;
use App\Models\Destination;
use App\Models\Device;
use App\Models\File;
use App\Models\Photo;
use App\Models\Video;
use App\Models\Article;
use App\Models\Lastminute;
use App\Models\Premium;
use App\Models\Profile;
use App\Models\Resort;
use App\Models\Restaurant;
use App\Models\Token;

use App\Traits\Filter;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Caffeinated\Shinobi\Traits\ShinobiTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable,
        CanResetPassword,
        ShinobiTrait,
        Filter,
        \App\Traits\Model,
        \App\Traits\Relations\Files;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $sortable = [
        'name',
        'email',
        'role_id'
    ];

    protected $searchable = [
        'name',
        'email',
    ];

    /**
     * Users can have many roles.
     * Overwrite ShinobiTrait method
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role')->withTimestamps();
    }

    public function getAvatarAttribute()
    {
        //'vendor/admin-lte/img/user2-160x160.jpg'
        return $this->attributes['avatar'] ? $this->attributes['avatar'] : "img/default-avatar.png";
    }

    /**
     * This mutator automatically hashes the password.
     *
     * @var string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function premium()
    {
        return $this->hasOne(Premium::class);
    }

    public function getIsPremiumAttribute()
    {
        if (is_null($this->premium))
            return false;

        return ($this->premium->status) ? true : false;
    }

    public function token()
    {
        return $this->hasOne(Token::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    // Get a list of users following us
    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'follow_id', 'user_id')->withTimestamps()->orderBy('id');
    }

    // Get all users we are following
    public function following()
    {
        return $this->belongsToMany(self::class, 'followers', 'user_id', 'follow_id')->withTimestamps()->orderBy('id');
    }

    public function likedDeals()
    {
        return $this->morphedByMany(Deal::class, 'likeable')->where('likeables.deleted_at', null);
    }

    public function likedLastminutes()
    {
        return $this->morphedByMany(Lastminute::class, 'likeable')->where('likeables.deleted_at', null);
    }

    public function likedDestinations()
    {
        return $this->morphedByMany(Destination::class, 'likeable')->where('likeables.deleted_at', null);
    }

    public function likedAccommodations()
    {
        return $this->morphedByMany(Accommodation::class, 'likeable')->where('likeables.deleted_at', null);
    }

    public function likedRestaurants()
    {
        return $this->morphedByMany(Restaurant::class, 'likeable')->where('likeables.deleted_at', null);
    }

    public function likedResorts()
    {
        return $this->morphedByMany(Resort::class, 'likeable')->where('likeables.deleted_at', null);
    }

    public function likedFiles()
    {
        return $this->morphedByMany(File::class, 'likeable')->where('likeables.deleted_at', null);
    }

    public function likedPhotos()
    {
        return $this->morphedByMany(Photo::class, 'likeable')->where('likeables.deleted_at', null);
    }

    public function likedVideos()
    {
        return $this->morphedByMany(Video::class, 'likeable')->where('likeables.deleted_at', null);
    }

    public function likedArticles()
    {
        return $this->morphedByMany(Article::class, 'likeable')->where('likeables.deleted_at', null);
    }

    public function commentedDeals()
    {
        return $this->morphedByMany(Deal::class, 'commentable')->where('commentables.deleted_at', null);
    }

    public function commentedLastminutes()
    {
        return $this->morphedByMany(Lastminute::class, 'commentable')->where('commentables.deleted_at', null);
    }

    public function commentedDestinations()
    {
        return $this->morphedByMany(Destination::class, 'commentable')->where('commentables.deleted_at', null);
    }

    public function commentedAccommodations()
    {
        return $this->morphedByMany(Accommodation::class, 'commentable')->where('commentables.deleted_at', null);
    }

    public function commentedRestaurants()
    {
        return $this->morphedByMany(Restaurant::class, 'commentable')->where('commentables.deleted_at', null);
    }

    public function commentedResorts()
    {
        return $this->morphedByMany(Resort::class, 'commentable')->where('commentables.deleted_at', null);
    }

    public function commentedFiles()
    {
        return $this->morphedByMany(File::class, 'commentable')->where('commentables.deleted_at', null);
    }

    public function sharedDeals()
    {
        return $this->morphedByMany(Deal::class, 'sharing', 'shares')->where('shares.deleted_at', null);
    }

    public function sharedLastminutes()
    {
        return $this->morphedByMany(Lastminute::class, 'sharing', 'shares')->where('shares.deleted_at', null);
    }

    public function sharedDestinations()
    {
        return $this->morphedByMany(Destination::class, 'sharing', 'shares')->where('shares.deleted_at', null);
    }

    public function sharedAccommodations()
    {
        return $this->morphedByMany(Accommodation::class, 'sharing', 'shares')->where('shares.deleted_at', null);
    }

    public function sharedRestaurants()
    {
        return $this->morphedByMany(Restaurant::class, 'sharing', 'shares')->where('shares.deleted_at', null);
    }

    public function sharedResorts()
    {
        return $this->morphedByMany(Resort::class, 'sharing', 'shares')->where('shares.deleted_at', null);
    }

    public function sharedFiles()
    {
        return $this->morphedByMany(File::class, 'sharing', 'shares')->where('shares.deleted_at', null);
    }

    public function sharedPhotos()
    {
        return $this->morphedByMany(Photo::class, 'sharing', 'shares')->where('shares.deleted_at', null);
    }

    public function sharedVideos()
    {
        return $this->morphedByMany(Video::class, 'sharing', 'shares')->where('shares.deleted_at', null);
    }
}
