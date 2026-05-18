<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Setting;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\Core\Models\Setting;
use App\MoonShine\Resources\Setting\Pages\SettingFormPage;
use App\MoonShine\Resources\Setting\Pages\SettingIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\TypeCasts\ModelDataWrapper;

/**
 * @extends ModelResource<Setting, SettingIndexPage, SettingFormPage>
 */
class SettingResource extends ModelResource
{
    protected string $model = Setting::class;

    protected string $title = 'Settings';

    protected string $icon = 'cog';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            SettingIndexPage::class,
            SettingFormPage::class,
        ];
    }

    /**
     * Scope the list query to only the singleton row.
     */
    protected function query(): Builder
    {
        Setting::instance();
        return parent::query()->where('id', 1);
    }

    /**
     * Called by findItem() when loading the model for the form page.
     * Ensures the singleton record exists before attempting to find it.
     */
    protected function modifyItemQueryBuilder(Builder $builder): Builder
    {
        Setting::instance();
        return $builder;
    }
}
