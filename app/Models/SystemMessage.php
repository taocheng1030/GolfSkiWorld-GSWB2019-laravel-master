<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemMessage extends Model
{
    use SoftDeletes;

    const TYPE_MAIL = 1;
    const TYPE_MESSAGE = 2;
    const TYPE_NOTIFICATION = 3;
    const TYPE_FILE = 4;

    protected $fillable = [
        'messageable_id',
        'messageable_type',
        'type',
        'message',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'messageable_id',
        'messageable_type',
        'deleted_at',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function messageable()
    {
        return $this->morphTo();
    }

    public function getDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
