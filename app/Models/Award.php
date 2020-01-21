<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
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
