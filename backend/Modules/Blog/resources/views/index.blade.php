<x-layouts.app>

    <section class="mx-auto max-w-6xl px-4 py-12">
        <h1 class="mb-8 text-3xl font-bold text-navy">{{ __('nav.blog') }}</h1>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($articles as $article)
                @php
                    $artLocale = app()->getLocale();
                    $artSlug   = $article->getLocalizedRouteKey($artLocale);
                    $artUrl    = $artSlug
                        ? \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($artLocale, 'routes.blog.show', ['article' => $artSlug])
                        : \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($artLocale, 'routes.blog');
                @endphp
                <article class="flex flex-col overflow-hidden rounded-lg border border-gray-100 shadow-sm transition hover:shadow-md">
                    @if($article->hasMedia('featured'))
                        @php
                            $media   = $article->getFirstMedia('featured');
                            $avifUrl = $media->hasGeneratedConversion('avif')  ? $media->getUrl('avif')  : null;
                            $webpUrl = $media->hasGeneratedConversion('webp')  ? $media->getUrl('webp')  : null;
                            $src     = $media->hasGeneratedConversion('thumb') ? $media->getUrl('thumb') : $media->getUrl();
                        @endphp
                        <picture>
                            @if($avifUrl)<source srcset="{{ $avifUrl }}" type="image/avif">@endif
                            @if($webpUrl)<source srcset="{{ $webpUrl }}" type="image/webp">@endif
                            <img src="{{ $src }}" alt="{{ $article->title }}"
                                 class="h-48 w-full object-cover" loading="lazy">
                        </picture>
                    @else
                        <div class="h-48 w-full bg-navy-100"></div>
                    @endif

                    <div class="flex flex-1 flex-col p-5">
                        @if($article->category)
                            <span class="mb-2 text-xs font-semibold uppercase tracking-wide text-brand">
                                {{ $article->category->name }}
                            </span>
                        @endif

                        <h2 class="mb-2 text-lg font-semibold leading-snug text-navy">
                            <a href="{{ $artUrl }}" class="hover:text-brand transition">
                                {{ $article->title }}
                            </a>
                        </h2>

                        <p class="mb-4 flex-1 text-sm text-gray-600">{{ $article->excerpt }}</p>

                        <a href="{{ $artUrl }}" class="text-sm font-medium text-brand hover:underline">
                            {{ __('blog.read_more') }} →
                        </a>
                    </div>
                </article>
            @empty
                <p class="text-gray-500 col-span-3">{{ __('blog.no_articles') }}</p>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $articles->links() }}
        </div>
    </section>

</x-layouts.app>
