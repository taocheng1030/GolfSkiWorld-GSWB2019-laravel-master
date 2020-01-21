<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use \App\Traits\Model,
        \App\Traits\Localize,
        \App\Traits\Filter;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'user_id',
        'contact_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->hasMany(User::class);
    }
}
