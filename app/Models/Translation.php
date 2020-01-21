<?php

namespace App\Models;

use App\Traits\Filter;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use Filter;

    protected $fillable = [
        'language_id',
        'key',
        'translate',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'language_id'
    ];

    protected $sortable = [
        'key',
        'translate',
        'languages.name',
    ];

    protected $searchable = [
        'key',
        'translate',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
