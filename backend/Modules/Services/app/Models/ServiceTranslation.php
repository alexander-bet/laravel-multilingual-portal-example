<?php

declare(strict_types=1);

namespace Modules\Services\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTranslation extends Model
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
        'content' => 'array',
    ];
}
