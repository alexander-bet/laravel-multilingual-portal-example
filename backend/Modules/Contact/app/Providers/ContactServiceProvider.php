<?php

namespace Modules\Contact\Providers;

use Illuminate\Support\Facades\View;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\Services\Repositories\ServiceRepository;

class ContactServiceProvider extends ModuleServiceProvider
{
    protected string $name = 'Contact';

    protected string $nameLower = 'contact';

    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    public function boot(): void
    {
        parent::boot();

        // Share published services to the lead-form component (both inline and popup)
        View::composer(
            ['components.lead-form', 'components.lead-form-popup'],
            function ($view) {
                $repo     = app(ServiceRepository::class);
                $services = $repo->getAll();
                $view->with('services', $services);
            }
        );
    }
}
