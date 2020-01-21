<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealLimiter extends Model
{
    use \App\Traits\Model;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
