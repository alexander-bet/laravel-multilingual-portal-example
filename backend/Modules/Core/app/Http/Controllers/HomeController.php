<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers;

use Butschster\Head\Facades\Meta;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Core\Traits\SetsHreflang;
use Modules\Core\Traits\SetsOpenGraph;
use Modules\Blog\Services\ArticleService;
use Modules\Personnel\Models\Personnel;
use Modules\Pricing\Models\PricingPlan;
use Modules\Services\Services\ServiceService;

class HomeController extends Controller
{
    use SetsHreflang, SetsOpenGraph;

    public function __construct(
        private readonly ServiceService $serviceService,
        private readonly ArticleService $articleService,
    ) {}

    public function index(): View
    {
        $title       = __('home.meta_title');
        $description = __('home.meta_description');

        Meta::prependTitle($title)->setDescription($description);

        $this->setStaticOg($title, $description, asset('images/og-default.jpg'));
        $this->setHomeHreflang();

        $featuredServices = $this->serviceService->getFeaturedServices();
        $allServices      = $this->serviceService->listServices();
        $newsArticles     = $this->articleService->getLatestByCategorySlug('novosti', 'ru', 9);
        $personnel        = Personnel::with(['translations', 'media'])
            ->orderBy('sort_order')
            ->get();

        $pricingPlans     = PricingPlan::with('translations')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('core::home', compact('featuredServices', 'allServices', 'newsArticles', 'personnel', 'pricingPlans'));
    }
}
