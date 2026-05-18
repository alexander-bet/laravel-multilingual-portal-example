<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Lead;

use Modules\Contact\Models\Lead;
use App\MoonShine\Resources\Lead\Pages\LeadDetailPage;
use App\MoonShine\Resources\Lead\Pages\LeadFormPage;
use App\MoonShine\Resources\Lead\Pages\LeadIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\SortDirection;

/**
 * @extends ModelResource<Lead, LeadIndexPage, LeadFormPage, LeadDetailPage>
 */
class LeadResource extends ModelResource
{
    protected string $model = Lead::class;

    protected string $title = 'Leads';

    protected string $sortColumn = 'created_at';

    protected SortDirection $sortDirection = SortDirection::DESC;

    protected bool $createInModal = false;

    protected function pages(): array
    {
        return [
            LeadIndexPage::class,
            LeadFormPage::class,
            LeadDetailPage::class,
        ];
    }

    protected function with(): array
    {
        return ['service.translations'];
    }
}
