<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localization extends Model
{
    protected $hidden =[
        'created_at',
        'updated_at',
        'localizable_id',
        'localizable_type',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function localizable()
    {
        return $this->morphTo();
    }
}
