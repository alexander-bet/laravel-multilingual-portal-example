@use('Sckatik\MoonshineEditorJs\Facades\RenderEditorJs')
<x-layouts.app>

    {{-- ── Hero ───────────────────────────────────────────────────────────── --}}
    <section class="relative mx-auto max-w-6xl overflow-hidden px-4 py-12 lg:py-24">

        {{-- Faint grid background --}}
        <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(to_right,#e2e8f020_1px,transparent_1px),linear-gradient(to_bottom,#e2e8f020_1px,transparent_1px)] bg-size-[48px_48px]" aria-hidden="true"></div>

        {{-- Breadcrumb --}}
        <nav class="animate-fade-up mb-8 flex items-center gap-2 text-sm text-gray-500" style="animation-delay:0ms">
            <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated(app()->getLocale(), 'routes.services') }}"
               class="transition hover:text-brand">{{ __('nav.services') }}</a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-800">{{ $service->title }}</span>
        </nav>

        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-20">

            {{-- ── Left: image block ──────────────────────────────────────── --}}
            <div class="animate-fade-up relative" style="animation-delay:100ms">


                {{-- Bottom-left brand block --}}
                <div class="animate-slide-in-left absolute -bottom-5 -inset-s-5 h-36 w-36 bg-brand" aria-hidden="true" style="animation-delay:300ms"></div>

                {{-- Image --}}
                @if($service->hasMedia('cover'))
                    @php
                        $media = $service->getFirstMedia('cover');
                        $avifUrl  = $media->hasGeneratedConversion('avif')  ? $media->getUrl('avif')  : null;
                        $webpUrl  = $media->hasGeneratedConversion('webp')  ? $media->getUrl('webp')  : null;
                        $thumbUrl = $media->hasGeneratedConversion('thumb') ? $media->getUrl('thumb') : $media->getUrl();
                    @endphp
                    <picture class="relative block overflow-hidden shadow-2xl">
                        @if($avifUrl)<source srcset="{{ $avifUrl }}" type="image/avif">@endif
                        @if($webpUrl)<source srcset="{{ $webpUrl }}" type="image/webp">@endif
                        <img src="{{ $thumbUrl }}"
                             alt="{{ $service->title }}"
                             class="relative w-full object-cover transition-transform duration-700 hover:scale-105"
                             style="max-height:520px">
                    </picture>
                @else
                    <div class="relative h-80 w-full bg-navy-100 shadow-2xl lg:h-130"></div>
                @endif

                {{-- Floating stat badge --}}
                <div class="animate-fade-up absolute -inset-e-6 bottom-10 z-20 hidden rounded-2xl bg-white px-5 py-3 shadow-xl ring-1 ring-gray-100 lg:flex lg:items-center lg:gap-3"
                     style="animation-delay:500ms">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-brand/10">
                        <svg class="size-5 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="text-xs text-gray-400">{{ __('services.guarantee') }}</p>
                        <p class="text-sm font-semibold text-navy">{{ __('services.guarantee_value') }}</p>
                    </div>
                </div>
            </div>

            {{-- ── Right: text block ──────────────────────────────────────── --}}
            <div class="relative">

                {{-- Eyebrow --}}
                <p class="animate-fade-up mb-3 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-brand"
                   style="animation-delay:150ms">
                    <span class="inline-block h-px w-8 bg-brand"></span>
                    {{ __('nav.services') }}
                </p>

                {{-- Title --}}
                <h1 class="animate-fade-up mb-6 text-4xl font-extrabold leading-tight text-navy lg:text-5xl"
                    style="animation-delay:220ms">
                    {{ $service->title }}
                </h1>

                {{-- Excerpt --}}
                @if($service->excerpt)
                    <p class="animate-fade-up mb-8 text-base leading-relaxed text-gray-600 lg:text-lg"
                       style="animation-delay:300ms">
                        {{ $service->excerpt }}
                    </p>
                @endif

                {{-- CTA --}}
                <div class="animate-fade-up flex flex-wrap items-center gap-4" style="animation-delay:380ms">
                    <button
                        type="button"
                        onclick="window.dispatchEvent(new CustomEvent('lead-form:open', { detail: { preselect: {{ $service->id }} } }))"
                        class="btn-primary group relative overflow-hidden">
                        <span class="relative z-10">{{ __('nav.cta') }}</span>
                        <span class="absolute inset-0 -translate-x-full bg-white/10 transition-transform duration-300 group-hover:translate-x-0"></span>
                    </button>
                    <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated(app()->getLocale(), 'routes.services') }}"
                       class="text-sm font-semibold text-navy underline-offset-4 transition hover:text-brand hover:underline">
                        ← {{ __('nav.all_services') }}
                    </a>
                </div>

                {{-- Decorative dots grid --}}
                <div class="pointer-events-none absolute -bottom-10 -inset-e-10 hidden opacity-20 lg:block" aria-hidden="true">
                    <svg width="120" height="120" viewBox="0 0 120 120" fill="currentColor" class="text-navy">
                        @for($r = 0; $r < 5; $r++)
                            @for($c = 0; $c < 5; $c++)
                                <circle cx="{{ 12 + $c * 24 }}" cy="{{ 12 + $r * 24 }}" r="3"/>
                            @endfor
                        @endfor
                    </svg>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Body content ───────────────────────────────────────────────────── --}}
    @if($service->content)
        <div class="relative mx-auto max-w-4xl px-4 pb-20 pt-16">

            {{-- Vertical accent line --}}
            <div class="absolute inset-s-0 top-0 h-full w-1 bg-linear-to-b from-brand via-brand/30 to-transparent" aria-hidden="true"></div>

            <div class="prose prose-lg max-w-none ps-6
                        prose-headings:text-navy prose-headings:font-bold
                        prose-a:text-brand prose-a:no-underline hover:prose-a:underline
                        prose-strong:text-navy">
                {!! RenderEditorJs::render($service->content) !!}
            </div>

            {{-- Bottom CTA band --}}
            <div class="mt-16 overflow-hidden rounded-2xl bg-navy px-8 py-10 text-center shadow-xl">
                <p class="mb-2 text-sm font-semibold uppercase tracking-widest text-brand">{{ __('nav.services') }}</p>
                <h2 class="mb-6 text-2xl font-bold text-white lg:text-3xl">{{ $service->title }}</h2>
                <button
                    type="button"
                    onclick="window.dispatchEvent(new CustomEvent('lead-form:open', { detail: { preselect: {{ $service->id }} } }))"
                    class="btn-primary">
                    {{ __('nav.cta') }}
                </button>
            </div>
        </div>
    @endif

</x-layouts.app>
