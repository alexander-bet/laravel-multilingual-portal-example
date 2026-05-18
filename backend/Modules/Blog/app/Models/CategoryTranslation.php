<?php

declare(strict_types=1);

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'meta_title',
        'meta_description',
    ];
}
