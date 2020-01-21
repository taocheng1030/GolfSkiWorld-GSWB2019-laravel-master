<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'bookable_id',
        'bookable_type',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'bookable_id',
        'bookable_type',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deals()
    {
        return $this->morphedByMany(Deal::class, 'bookable', 'bookings');
    }

    public function lastminutes()
    {
        return $this->morphedByMany(Lastminute::class, 'bookable', 'bookings');
    }

    public function bookable()
    {
        return $this->morphTo();
    }
}
