<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers;

use Butschster\Head\Facades\Meta;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Core\Traits\SetsHreflang;
use Modules\Core\Traits\SetsOpenGraph;
use Modules\Personnel\Models\Personnel;

class AboutController extends Controller
{
    use SetsHreflang, SetsOpenGraph;

    public function __invoke(): View
    {
        $title       = __('about.meta_title');
        $description = __('about.meta_description');

        Meta::prependTitle($title)->setDescription($description);

        $this->setStaticOg($title, $description, asset('images/og-default.jpg'));
        $this->setStaticHreflang('routes.about');

        $personnel        = Personnel::with(['translations', 'media'])
            ->orderBy('sort_order')
            ->get();

        return view('core::about', compact('personnel'));
    }
}
