<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\FileRepository;

class Deal extends Model
{
    use \App\Traits\Model,
        \App\Traits\Localize,
        \App\Traits\Relations\BCLS,
        \App\Traits\Relations\Files,
        \App\Traits\Filter;

    protected $hidden = [
        'created_at',
        'updated_at',
        'email',
        'sms',
        'push',
        'published',
        'localized'
    ];

    protected $appends = [
        'model',
        'locale',
    ];

    protected $fillable = [
        'name',
        'shortdescription',
        'description',
        'owner',
        'owner_email',
        'owner_phone',
        'currency',
        'link',
        'starts',
        'ends',
        'originalprice',
        'price',
        'numberofpurchases',
        'longitude',
        'latitude',
    ];

    public $localizedFields = [
        'name',
        'shortdescription',
        'description',
    ];

    protected $sortable = [
        'id',
        'sites.name',
        'deals.name',
        'views',
        'hits',
        'currency',
        'owner',
        'deal_limiters.name',
        'remaining',
    ];

    protected $searchable = [
        'deals.name',
        'owner',
    ];

    public function getEmailAttribute()
    {
        return $this->owner_email;
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function limiter()
    {
        return $this->belongsTo(DealLimiter::class);
    }

    public function resorts()
    {
        return $this->belongsToMany(Resort::class)->withTimestamps();
    }

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class)->withTimestamps();
    }

    public function accommodations()
    {
        return $this->belongsToMany(Accommodation::class)->withTimestamps();
    }
}
