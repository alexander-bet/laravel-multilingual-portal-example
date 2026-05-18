<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers;

use Butschster\Head\Facades\Meta;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Core\Traits\SetsHreflang;

class LegalController extends Controller
{
    use SetsHreflang;

    public function privacy(): View
    {
        $title       = __('privacy.meta_title');
        $description = __('privacy.meta_description');

        Meta::prependTitle($title)->setDescription($description);
        $this->setStaticHreflang('routes.privacy');

        return view('core::legal', ['langKey' => 'privacy']);
    }

    public function terms(): View
    {
        $title       = __('terms.meta_title');
        $description = __('terms.meta_description');

        Meta::prependTitle($title)->setDescription($description);
        $this->setStaticHreflang('routes.terms');

        return view('core::legal', ['langKey' => 'terms']);
    }
}
