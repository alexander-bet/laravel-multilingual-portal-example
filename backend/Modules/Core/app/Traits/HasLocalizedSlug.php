<?php

declare(strict_types=1);

namespace Modules\Core\Traits;

use Illuminate\Support\Facades\Cache;

trait HasLocalizedSlug
{
    // ── Auto-invalidation ─────────────────────────────────────────────────────
    // Laravel calls boot{TraitName}() automatically. Any Eloquent save/delete
    // (including MoonShine admin saves) clears all cached slug→ID entries for
    // this model instance, so the next request always resolves from the DB.

    protected static function bootHasLocalizedSlug(): void
    {
        static::saved(fn (self $model) => $model->clearRouteBindingCache());
        static::deleted(fn (self $model) => $model->clearRouteBindingCache());
    }

    // ── Route key / localized slug ────────────────────────────────────────────

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Called by mcamara/laravel-localization language switcher to build
     * the correct localized URL for each locale.
     */
    public function getLocalizedRouteKey($locale): ?string
    {
        if (! $this->relationLoaded('translations')) {
            $this->load('translations');
        }

        return $this->translations->where('locale', $locale)->first()?->slug;
    }

    // ── Route model binding ───────────────────────────────────────────────────

    /**
     * Cache only the slug→ID mapping, not the full model.
     * Works with any cache driver (file, redis, array, etc.).
     * Relationships are always loaded fresh so media/translation updates
     * appear immediately after the cache entry is cleared on save.
     */
    public function resolveRouteBinding($value, $field = null): ?static
    {
        $locale = app()->currentLocale();

        $cacheKey = $this->routeBindingCacheKey($value, $locale);
        $id       = Cache::get($cacheKey);

        if ($id === null) {
            $id = static::whereHas(
                'translations',
                fn ($q) => $q->where('slug', $value)->where('locale', $locale)
            )->value('id');

            // Never cache null: a miss today (e.g. right after --fresh import)
            // would lock out the URL for the full TTL even after the record exists.
            if ($id !== null) {
                Cache::put($cacheKey, $id, now()->addMinutes(15));
            }
        }

        abort_if(! $id, 404);

        return static::with($this->routeBindingEagerLoads())->findOrFail($id);
    }

    // ── Cache helpers ─────────────────────────────────────────────────────────

    protected function routeBindingCacheKey(string $slug, string $locale): string
    {
        return 'route-binding:' . str_replace('\\', '.', static::class) . ':' . $locale . ':' . $slug;
    }

    /**
     * Flush cached slug→ID entries for every translation of this model.
     * Called automatically on save/delete via bootHasLocalizedSlug().
     */
    public function clearRouteBindingCache(): void
    {
        if (! $this->relationLoaded('translations')) {
            $this->load('translations');
        }

        foreach ($this->translations as $translation) {
            if ($translation->slug) {
                Cache::forget($this->routeBindingCacheKey($translation->slug, $translation->locale));
            }
        }
    }

    // ── Override in the model to add eager loads needed on the show page ──────

    protected function routeBindingEagerLoads(): array
    {
        return ['translations'];
    }
}
