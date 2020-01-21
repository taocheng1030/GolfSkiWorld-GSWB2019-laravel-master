<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Awardinfo extends Model
{
    use \App\Traits\Model,
    \App\Traits\Localize,
    \App\Traits\Relations\Files,
    \App\Traits\Filter;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'left_title',
        'left_info',
        'middle_title',
        'middle_info',
        'right_title',
        'right_info'
    ];
}
