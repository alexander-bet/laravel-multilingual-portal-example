<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\Palettes\GrayPalette;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Contracts\ColorManager\PaletteContract;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\MenuManager\MenuItem;
use MoonShine\MenuManager\MenuGroup;
use App\MoonShine\Resources\Service\ServiceResource;
use App\MoonShine\Resources\Lead\LeadResource;
use App\MoonShine\Resources\Article\ArticleResource;
use App\MoonShine\Resources\Category\CategoryResource;
use App\MoonShine\Resources\Setting\SettingResource;
use App\MoonShine\Resources\Personnel\PersonnelResource;
use App\MoonShine\Resources\Pricing\PricingPlanResource;

final class MoonShineLayout extends AppLayout
{
    /**
     * @var null|class-string<PaletteContract>
     */
    protected ?string $palette = GrayPalette::class;

    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            ...parent::menu(),
            MenuItem::make(UserResource::class, 'Users'),
            MenuItem::make(ServiceResource::class, 'Services'),
            MenuItem::make(LeadResource::class, 'Leads'),
            MenuGroup::make('Blog', [
                MenuItem::make(ArticleResource::class, 'Articles'),
                MenuItem::make(CategoryResource::class, 'Categories'),
            ]),
            MenuItem::make(PersonnelResource::class, 'Personnel'),
            MenuItem::make(PricingPlanResource::class, 'Pricing'),
            MenuItem::make(SettingResource::class, 'Settings'),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }
}
