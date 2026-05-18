<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Pricing;

use Illuminate\Http\Request;
use Modules\Pricing\Models\PricingPlan;
use App\MoonShine\Resources\Pricing\Pages\PricingPlanIndexPage;
use App\MoonShine\Resources\Pricing\Pages\PricingPlanFormPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\Support\Enums\SortDirection;

/**
 * @extends ModelResource<PricingPlan, PricingPlanIndexPage, PricingPlanFormPage>
 */
class PricingPlanResource extends ModelResource
{
    protected string $model = PricingPlan::class;

    protected string $title = 'Pricing Plans';

    protected string $icon = 'currency-dollar';

    protected string $sortColumn = 'sort_order';
    protected SortDirection $sortDirection = SortDirection::ASC;
    protected bool $usePagination = false;

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            PricingPlanIndexPage::class,
            PricingPlanFormPage::class,
        ];
    }

    #[AsyncMethod]
    public function reorder(Request $request): void
    {
        $data = $request->input('data', '');

        if ($data !== '') {
            collect(explode(',', $data))->each(
                fn ($id, $position) => $this->getModel()
                    ->where('id', $id)
                    ->update(['sort_order' => $position + 1]),
            );
        }
    }
}
