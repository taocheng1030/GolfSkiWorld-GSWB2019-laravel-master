<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SocialInfo extends Model
{
    protected $fillable = ['comment', 'like',];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
