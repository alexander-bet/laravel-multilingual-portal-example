<?php

declare(strict_types=1);

namespace Modules\Personnel\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslatableAdminAttributes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Personnel extends Model implements HasMedia
{
    use Translatable, InteractsWithMedia, HasTranslatableAdminAttributes {
        HasTranslatableAdminAttributes::getAttribute insteadof Translatable;
        HasTranslatableAdminAttributes::setAttribute insteadof Translatable;
        Translatable::getAttribute as translatableGetAttribute;
        Translatable::setAttribute as translatableSetAttribute;
    }

    protected $table = 'personnel';

    public array $translatedAttributes = [
        'name',
        'position',
    ];

    protected $fillable = [
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')
            ->quality(85)
            ->width(600)
            ->height(700)
            ->performOnCollections('photo')
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->format('webp')
            ->width(300)
            ->height(350)
            ->quality(80)
            ->performOnCollections('photo')
            ->nonQueued();
    }
}
