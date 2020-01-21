<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facebook_id',
        'facebook_token',
        'google_id',
        'google_token',
    ];


    protected $hidden = [
        'id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
