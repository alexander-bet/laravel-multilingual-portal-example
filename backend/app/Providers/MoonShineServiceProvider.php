<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRole\MoonShineUserRoleResource;
use App\MoonShine\Resources\User\UserResource;
use App\MoonShine\Resources\Service\ServiceResource;
use App\MoonShine\Resources\Lead\LeadResource;
use App\MoonShine\Resources\Article\ArticleResource;
use App\MoonShine\Resources\Category\CategoryResource;
use App\MoonShine\Resources\Setting\SettingResource;
use App\MoonShine\Resources\Personnel\PersonnelResource;
use App\MoonShine\Resources\Pricing\PricingPlanResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  CoreContract<MoonShineConfigurator>  $core
     */
    public function boot(CoreContract $core): void
    {
        $core
            ->resources([
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                UserResource::class,
                ServiceResource::class,
                LeadResource::class,
                ArticleResource::class,
                CategoryResource::class,
                PersonnelResource::class,
                PricingPlanResource::class,
                SettingResource::class,
            ])
            ->pages([
                ...$core->getConfig()->getPages(),
            ])
        ;
    }
}
