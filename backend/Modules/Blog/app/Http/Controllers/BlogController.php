<?php

declare(strict_types=1);

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Butschster\Head\Facades\Meta;
use Illuminate\View\View;
use Modules\Blog\Models\Article;
use Modules\Blog\Models\Category;
use Modules\Blog\Services\ArticleService;
use Modules\Core\Traits\SetsHreflang;
use Modules\Core\Traits\SetsOpenGraph;

class BlogController extends Controller
{
    use SetsHreflang, SetsOpenGraph;

    public function __construct(
        private readonly ArticleService $service,
    ) {}

    public function index(): View
    {
        $title       = __('blog.meta_title');
        $description = __('blog.meta_description');

        Meta::prependTitle($title)->setDescription($description);

        $this->setStaticOg($title, $description);
        $this->setStaticHreflang('routes.blog');

        $articles   = $this->service->listArticles();
        $categories = $this->service->listCategories();

        return view('blog::index', compact('articles', 'categories'));
    }

    public function show(Article $article): View
    {
        $title       = $article->meta_title ?: $article->title;
        $description = $article->meta_description ?: $article->excerpt;
        $image       = $article->getFirstMediaUrl('featured', 'webp') ?: $article->getFirstMediaUrl('featured');

        Meta::prependTitle($title)->setDescription($description);

        $this->setModelOg($title, $description ?: '', $image ?: null, 'article');
        $this->setModelHreflang('routes.blog.show', $article, 'article', 'routes.blog');

        return view('blog::show', compact('article'));
    }

    public function category(Category $category): View
    {
        $articles    = $this->service->getArticlesByCategory($category);
        $title       = $category->meta_title ?: $category->name;
        $description = $category->meta_description ?: $category->description;

        Meta::prependTitle($title)->setDescription($description);

        $this->setStaticOg($title, $description ?: '');
        $this->setModelHreflang('routes.blog.category', $category, 'category', 'routes.blog');

        return view('blog::category', compact('category', 'articles'));
    }
}
