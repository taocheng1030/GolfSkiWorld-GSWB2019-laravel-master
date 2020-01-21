<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use \App\Traits\Model,
    \App\Traits\Localize,
    \App\Traits\Relations\Files,
    \App\Traits\Filter;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'name',
        'contact',
        'description',
        'order'
    ];
}
