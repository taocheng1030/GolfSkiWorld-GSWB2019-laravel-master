<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resort extends Model
{
    use \App\Traits\Model,
        \App\Traits\Localize,
        \App\Traits\Relations\Files,
        \App\Traits\Filter;

    protected $hidden = [
        'created_at',
        'updated_at',
        'localized'
    ];

    protected $appends = [
        'model',
        'locale',
    ];

    protected $fillable = [
        'name', 
        'description',
        'details',
        'administrator',
        'longitude', 
        'latitude',      
        'street', 
        'zip',  
        'phone', 
        'email',  
        'link', 
    ];

    public $localizedFields = [
        'name',
        'description',
        'details'
    ];

    protected $sortable = [
        'id',
        'sites.name',
        'resorts.name',
        'street',
        'cities.name',
        'countries.name',
        'latitude',
        'longitude',
    ];

    protected $searchable = [
        'resorts.name',
        'street',
        'cities.name',
        'latitude',
        'longitude',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class)->withTimestamps();
    }

    public function accommodations()
    {
        return $this->belongsToMany(Accommodation::class)->withTimestamps();
    }

    public function deals()
    {
        return $this->belongsToMany(Deal::class)->withTimestamps();
    }

    public function lastminutes()
    {
        return $this->belongsToMany(Lastminute::class)->withTimestamps();
    }

    public function destinfos()
    {
        return $this->belongsToMany(Destinfo::class)->withTimestamps();
    }
}
