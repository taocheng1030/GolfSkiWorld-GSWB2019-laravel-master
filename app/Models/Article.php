<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use \App\Traits\Model,
    \App\Traits\Localize,
    \App\Traits\Relations\Files,
    \App\Traits\Filter;

    protected $hidden = [
        'created_at',
        'updated_at',
        'textinmenu',
        'inmenu',
        'startpage',
    ];

    protected $fillable = [
        'name',
        'summary',
        'body',
        'tags',
        'author',
        'publish_at',
    ];

    protected $sortable = [
        'id',
        'sites.name',
        'articles.name',
        'languages.name',
        'published',
    ];



    protected $searchable = [
        'articles.name'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
    
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
