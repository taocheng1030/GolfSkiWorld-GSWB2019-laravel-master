<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use \App\Traits\Model,
    \App\Traits\Localize,
    \App\Traits\Filter;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'description',
        'link'
    ];
}
