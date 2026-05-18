<?php

declare(strict_types=1);

namespace Modules\Blog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mcamara\LaravelLocalization\Interfaces\LocalizedUrlRoutable;
use Modules\Core\Traits\HasLocalizedSlug;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Article extends Model implements HasMedia, LocalizedUrlRoutable
{
    use HasFactory, Translatable, InteractsWithMedia, HasLocalizedSlug;

    protected static function newFactory(): \Modules\Blog\Database\Factories\ArticleFactory
    {
        return \Modules\Blog\Database\Factories\ArticleFactory::new();
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
        'category_id',
        'author_id',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')
            ->quality(85)
            ->performOnCollections('featured')
            ->nonQueued();

        $this->addMediaConversion('avif')
            ->format('avif')
            ->quality(80)
            ->performOnCollections('featured')
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->format('webp')
            ->width(800)
            ->height(450)
            ->quality(80)
            ->performOnCollections('featured')
            ->nonQueued();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    protected function routeBindingEagerLoads(): array
    {
        return ['translations', 'media', 'category.translations'];
    }
}
