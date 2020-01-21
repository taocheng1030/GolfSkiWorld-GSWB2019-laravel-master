<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    const TYPE_APPLE = 1;
    const TYPE_ANDROID = 2;
    const TYPE_WINDOWS = 3;

    protected $fillable = [
        'user_id',
        'UDID',
        'device_token',
        'device_type',
        'subscribe'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
