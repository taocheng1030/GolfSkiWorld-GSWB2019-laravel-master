<?php

namespace App;

class Role extends \Caffeinated\Shinobi\Models\Role
{
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'pivot'
    ];
}
