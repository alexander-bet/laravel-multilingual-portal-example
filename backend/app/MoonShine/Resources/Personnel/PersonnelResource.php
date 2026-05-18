<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Personnel;

use Illuminate\Http\Request;
use Modules\Personnel\Models\Personnel;
use App\MoonShine\Resources\Personnel\Pages\PersonnelIndexPage;
use App\MoonShine\Resources\Personnel\Pages\PersonnelFormPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\Support\Enums\SortDirection;

/**
 * @extends ModelResource<Personnel, PersonnelIndexPage, PersonnelFormPage>
 */
class PersonnelResource extends ModelResource
{
    protected string $model = Personnel::class;

    protected string $title = 'Personnel';

    protected string $icon = 'users';

    protected string $sortColumn = 'sort_order';
    protected SortDirection $sortDirection = SortDirection::ASC;
    protected bool $usePagination = false;

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            PersonnelIndexPage::class,
            PersonnelFormPage::class,
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
