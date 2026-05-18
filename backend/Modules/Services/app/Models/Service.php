<?php

declare(strict_types=1);

namespace Modules\Services\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Interfaces\LocalizedUrlRoutable;
use Modules\Core\Traits\HasLocalizedSlug;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Service extends Model implements HasMedia, LocalizedUrlRoutable
{
    use HasFactory, Translatable, InteractsWithMedia, HasLocalizedSlug;

    protected static function newFactory(): \Modules\Services\Database\Factories\ServiceFactory
    {
        return \Modules\Services\Database\Factories\ServiceFactory::new();
    }

    public array $translatedAttributes = [
        'slug',
        'title',
        'excerpt',
        'content',
        'meta_title',
        'meta_description',
    ];

    protected $fillable = [
        'status',
        'featured',
        'icon',
        'sort_order',
        'featured_image',
    ];

    protected $casts = [
        'featured' => 'boolean',
    ];

    public function getIconAttribute(?string $value): ?string
    {
        if (!$value) {
            return null;
        }
        // MoonShine may HTML-encode the textarea value on save;
        // decode so the SVG renders as markup, not as visible text.
        $decoded = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return $decoded ?: null;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')
            ->quality(85)
            ->performOnCollections('cover')
            ->nonQueued();

        $this->addMediaConversion('avif')
            ->format('avif')
            ->quality(80)
            ->performOnCollections('cover')
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->format('webp')
            ->width(800)
            ->height(450)
            ->quality(80)
            ->performOnCollections('cover')
            ->nonQueued();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    protected function routeBindingEagerLoads(): array
    {
        return ['translations', 'media'];
    }
}
