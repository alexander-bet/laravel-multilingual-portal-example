@use('Sckatik\MoonshineEditorJs\Facades\RenderEditorJs')
<x-layouts.app>

    <article class="mx-auto max-w-3xl px-4 py-12">

        {{-- Breadcrumb --}}
        <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ LaravelLocalization::localizeURL(route('blog.index')) }}" class="hover:text-brand transition">{{ __('nav.blog') }}</a>
            @if($article->category)
                @php
                    $catLocale = app()->getLocale();
                    $catSlug   = $article->category->getLocalizedRouteKey($catLocale);
                    $catUrl    = $catSlug
                        ? \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($catLocale, 'routes.blog.category', ['category' => $catSlug])
                        : \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($catLocale, 'routes.blog');
                @endphp
                <span>/</span>
                <a href="{{ $catUrl }}" class="hover:text-brand transition">{{ $article->category->name }}</a>
            @endif
            <span>/</span>
            <span class="text-gray-800">{{ $article->title }}</span>
        </nav>

        @if($article->category)
            <span class="mb-3 inline-block text-xs font-semibold uppercase tracking-wide text-brand">
                {{ $article->category->name }}
            </span>
        @endif

        <h1 class="mb-6 text-3xl font-bold leading-tight text-navy">{{ $article->title }}</h1>

        @if($article->published_at)
            <p class="mb-8 text-sm text-gray-400">{{ $article->published_at->format('d.m.Y') }}</p>
        @endif

        @if($article->hasMedia('featured'))
            @php
                $media   = $article->getFirstMedia('featured');
                $avifUrl = $media->hasGeneratedConversion('avif') ? $media->getUrl('avif') : null;
                $webpUrl = $media->hasGeneratedConversion('webp') ? $media->getUrl('webp') : null;
                $src     = $media->getUrl();
            @endphp
            <picture>
                @if($avifUrl)<source srcset="{{ $avifUrl }}" type="image/avif">@endif
                @if($webpUrl)<source srcset="{{ $webpUrl }}" type="image/webp">@endif
                <img src="{{ $src }}" alt="{{ $article->title }}"
                     class="mb-8 w-full rounded-lg object-cover"
                     loading="eager" fetchpriority="high">
            </picture>
        @endif

        {{-- Editor.js content renderer --}}
        @if($article->content)
            @php
                // Moonshine admin stores content as a JSON string inside JSONB → cast returns PHP string.
                // Imported content is stored as a JSON object → cast returns PHP array.
                // Normalise to a JSON string so RenderEditorJs always receives the correct type.
                $contentJson = is_array($article->content)
                    ? json_encode($article->content)
                    : $article->content;
            @endphp
            <div class="prose prose-lg max-w-none
                        prose-headings:text-navy prose-headings:font-bold
                        prose-a:text-brand prose-a:no-underline hover:prose-a:underline
                        prose-strong:text-navy">
                {!! RenderEditorJs::render($contentJson) !!}
            </div>
        @endif

    </article>

</x-layouts.app>
