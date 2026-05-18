<?php

declare(strict_types=1);

namespace Modules\Services\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Services\Models\Service;

class ServiceRepository
{
    public function getAll(): Collection
    {
        $locale = app()->getLocale();

        return Service::with(['translations', 'media'])
            ->published()
            ->whereHas('translations', fn ($q) => $q->where('locale', $locale)->whereNotNull('title')->where('title', '!=', ''))
            ->orderBy('sort_order')
            ->get();
    }

    public function getFeatured(): Collection
    {
        $locale = app()->getLocale();

        return Service::with(['translations', 'media'])
            ->published()
            ->featured()
            ->whereHas('translations', fn ($q) => $q->where('locale', $locale)->whereNotNull('title')->where('title', '!=', ''))
            ->orderBy('sort_order')
            ->get();
    }
}
