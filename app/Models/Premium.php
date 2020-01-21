<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Premium extends Model
{
    protected $table = 'premiums';

    protected $fillable = [
        'request',
        'request_at',
        'decline',
        'decline_at',
        'approve',
        'approve_at',
        'suspend',
        'suspended_at',
        'status'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'user_id',
        'request_at',
        'decline_at',
        'approve_at',
        'suspended_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function change($field, $bool = false)
    {
        $this->setAttribute($field, $bool);
        $this->setAttribute($field.'_at', Carbon::now());
        $this->save();

        return true;
    }
}
