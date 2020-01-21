<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localized extends Model
{
    protected $table = 'localized';

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'localized_id',
        'localized_type',
    ];

    public function localized()
    {
        return $this->morphTo();
    }
}
