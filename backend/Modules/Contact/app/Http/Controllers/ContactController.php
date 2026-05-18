<?php

declare(strict_types=1);

namespace Modules\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Butschster\Head\Facades\Meta;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Contact\Http\Requests\ContactFormRequest;
use Modules\Contact\Services\ContactService;
use Modules\Core\Traits\SetsHreflang;
use Modules\Core\Traits\SetsOpenGraph;
use Modules\Core\Models\Setting;

class ContactController extends Controller
{
    use SetsHreflang, SetsOpenGraph;

    public function __construct(
        private readonly ContactService $service,
    ) {}

    public function index(): View
    {
        $title       = __('contact.meta_title');
        $description = __('contact.meta_description');

        Meta::prependTitle($title)->setDescription($description);

        $this->setStaticOg($title, $description);
        $this->setStaticHreflang('routes.contact');

        Meta::includePackages('leaflet');

        $settings = Setting::instance();

        return view('contact::index', compact('settings'));
    }

    public function store(ContactFormRequest $request): RedirectResponse
    {
        $this->service->handle($request);

        return redirect()
            ->route('contact.index')
            ->with('success', true);
    }
}
