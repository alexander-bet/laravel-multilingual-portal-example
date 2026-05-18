<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Service;

use Modules\Services\Models\Service;
use App\MoonShine\Resources\Service\Pages\ServiceIndexPage;
use App\MoonShine\Resources\Service\Pages\ServiceFormPage;
use App\MoonShine\Resources\Service\Pages\ServiceDetailPage;
use MoonShine\Contracts\Core\PageContract;
use Illuminate\Http\Request;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\Support\Enums\SortDirection;

/**
 * @extends ModelResource<Service, ServiceIndexPage, ServiceFormPage, ServiceDetailPage>
 */
class ServiceResource extends ModelResource
{
    protected string $model = Service::class;

    protected string $title = 'Services';

    protected string $sortColumn = 'sort_order';
    protected SortDirection $sortDirection = SortDirection::ASC;
    protected bool $usePagination = false;

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ServiceIndexPage::class,
            ServiceFormPage::class,
            ServiceDetailPage::class,
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
