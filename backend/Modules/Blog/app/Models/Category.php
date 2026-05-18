<?php

declare(strict_types=1);

namespace Modules\Blog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mcamara\LaravelLocalization\Interfaces\LocalizedUrlRoutable;
use Modules\Core\Traits\HasLocalizedSlug;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Category extends Model implements HasMedia, LocalizedUrlRoutable
{
    use HasFactory, Translatable, InteractsWithMedia, HasLocalizedSlug;

    protected static function newFactory(): \Modules\Blog\Database\Factories\CategoryFactory
    {
        return \Modules\Blog\Database\Factories\CategoryFactory::new();
    }

    public array $translatedAttributes = [
        'slug',
        'name',
        'description',
        'meta_title',
        'meta_description',
    ];

    protected $fillable = [
        'parent_id',
        'sort_order',
    ];

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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    protected function routeBindingEagerLoads(): array
    {
        return ['translations'];
    }
}
