<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use \App\Traits\Model,
        \App\Traits\Localize,
        \App\Traits\Relations\BCLS,
        \App\Traits\Relations\Files;

    protected $hidden = [
        'created_at',
        'updated_at',
        'localized'
    ];

    protected $appends = [
        'locale'
    ];

    protected $fillable = [
        'name',
        'description',
        'longitude',
        'latitude',
    ];

    public $localizedFields = [
        'name',
        'description',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mediatype()
    {
        return $this->belongsTo(MediaType::class);
    }
}
