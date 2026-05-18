<?php

declare(strict_types=1);

namespace Modules\Services\Http\Controllers;

use App\Http\Controllers\Controller;
use Butschster\Head\Facades\Meta;
use Illuminate\View\View;
use Modules\Core\Traits\SetsHreflang;
use Modules\Core\Traits\SetsOpenGraph;
use Modules\Services\Models\Service;
use Modules\Services\Services\ServiceService;

class ServiceController extends Controller
{
    use SetsHreflang, SetsOpenGraph;

    public function __construct(
        private readonly ServiceService $service,
    ) {}

    public function index(): View
    {
        $title       = __('services.meta_title');
        $description = __('services.meta_description');

        Meta::prependTitle($title)->setDescription($description);

        $this->setStaticOg($title, $description);
        $this->setStaticHreflang('routes.services');

        $services = $this->service->listServices();

        return view('services::index', compact('services'));
    }

    public function show(Service $service): View
    {
        $title       = $service->meta_title ?: $service->title;
        $description = $service->meta_description ?: $service->excerpt;
        $image       = $service->getFirstMediaUrl('cover', 'webp') ?: $service->getFirstMediaUrl('cover');

        Meta::prependTitle($title)->setDescription($description);

        $this->setModelOg($title, $description ?: '', $image ?: null, 'website');
        $this->setModelHreflang('routes.services.show', $service, 'service', 'routes.services');

        return view('services::show', compact('service'));
    }
}
