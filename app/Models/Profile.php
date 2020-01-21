<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language_id',
        'country_id',
        'state_id',
        'city_id',
        'firstname',
        'lastname',
        'address',
        'zip',
        'phone',
        'newsletter',
        'notify',
        'online_status',
        'show_info',
        'priority',
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

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

        public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
