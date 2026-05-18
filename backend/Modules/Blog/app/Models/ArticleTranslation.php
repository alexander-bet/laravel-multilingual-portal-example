<?php

declare(strict_types=1);

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'content',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'content' => 'array', // Editor.js JSON stored as jsonb
    ];
}
