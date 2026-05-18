{{--
    Footer component
    ─────────────────────────────────────────────────────────────
    4-column layout (desktop): logo+tagline, quick links, recent articles, social
    Collapses to 2-col on tablet, 1-col on mobile
--}}
@php
    $recentArticles = app(\Modules\Blog\Services\ArticleService::class)->listArticles(4);
    $settings       = \Modules\Core\Models\Setting::instance();
    $firstPhone     = collect($settings->phones ?? [])->first();
    $firstEmail     = collect($settings->emails ?? [])->first();
@endphp

<footer class="bg-navy text-gray-300">

    {{-- ── Main footer body ──────────────────────────────────── --}}
    <div class="mx-auto max-w-6xl px-4 py-12">
        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Column 1: Logo + tagline + contact --}}
            <div class="space-y-4">
                @if(LaravelLocalization::localizeURL(route('home')) === url()->current())
                    <div class="flex items-center gap-2">
                        <img src="/images/logo-mobile.svg" alt="{{ config('app.name') }}" class="h-8 w-auto brightness-0 invert">
                        <span class="text-xl font-semibold text-white">{{ config('app.name') }}</span>
                    </div>
                @else
                    <a href="{{ LaravelLocalization::localizeURL(route('home')) }}" class="flex items-center gap-2">
                        <img src="/images/logo-mobile.svg" alt="{{ config('app.name') }}" class="h-8 w-auto brightness-0 invert">
                        <span class="text-xl font-semibold text-white">{{ config('app.name') }}</span>
                    </a>
                @endif
                
                <p class="text-sm leading-relaxed text-gray-400">
                    {{ __('footer.tagline') }}
                </p>
                <ul class="space-y-2 text-sm">
                    @if($firstPhone)
                    <li class="flex items-center gap-2">
                        <svg class="size-4 shrink-0 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <a href="tel:{{ preg_replace('/\s+/', '', $firstPhone['number'] ?? '') }}"
                           class="transition hover:text-white">{{ $firstPhone['number'] ?? '' }}</a>
                    </li>
                    @endif
                    @if($firstEmail)
                    <li class="flex items-center gap-2">
                        <svg class="size-4 shrink-0 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:{{ $firstEmail['email'] ?? '' }}"
                           class="transition hover:text-white">{{ $firstEmail['email'] ?? '' }}</a>
                    </li>
                    @endif
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 size-4 shrink-0 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ __('header.address') }}</span>
                    </li>
                </ul>
            </div>

            {{-- Column 2: Quick links --}}
            <div>
                <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white">
                    {{ __('footer.links') }}
                </h3>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="{{ LaravelLocalization::localizeURL(route('blog.index')) }}"
                           class="transition hover:text-white">{{ __('nav.blog') }}</a>
                    </li>
                    <li>
                        <a href="{{ LaravelLocalization::localizeURL(route('services.index')) }}"
                           class="transition hover:text-white">{{ __('nav.services') }}</a>
                    </li>
                    <li>
                        <a href="{{ LaravelLocalization::localizeURL(route('contact.index')) }}"
                           class="transition hover:text-white">{{ __('nav.contact') }}</a>
                    </li>
                    @foreach(app(\Modules\Services\Services\ServiceService::class)->listServices() as $service)
                        @php
                            $svcLocale = app()->getLocale();
                            $svcSlug   = $service->getLocalizedRouteKey($svcLocale);
                            $svcUrl    = $svcSlug
                                ? \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($svcLocale, 'routes.services.show', ['service' => $svcSlug])
                                : \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($svcLocale, 'routes.services');
                        @endphp
                        <li>
                            <a href="{{ $svcUrl }}"
                               class="transition hover:text-white">{{ $service->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Column 3: Recent articles --}}
            <div>
                <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white">
                    {{ __('footer.recent_posts') }}
                </h3>
                <ul class="space-y-3 text-sm">
                    @forelse($recentArticles as $article)
                        @php
                            $artLocale = app()->getLocale();
                            $artSlug   = $article->getLocalizedRouteKey($artLocale);
                            $artUrl    = $artSlug
                                ? \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($artLocale, 'routes.blog.show', ['article' => $artSlug])
                                : \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($artLocale, 'routes.blog');
                        @endphp
                        <li>
                            <a href="{{ $artUrl }}"
                               class="leading-snug transition hover:text-white">
                                {{ $article->title }}
                            </a>
                            @if($article->published_at)
                                <p class="mt-0.5 text-xs text-gray-500">{{ $article->published_at->format('d.m.Y') }}</p>
                            @endif
                        </li>
                    @empty
                        <li class="text-gray-500">—</li>
                    @endforelse
                </ul>
            </div>

            {{-- Column 4: Social --}}
            <div>
                <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white">
                    {{ __('footer.follow_us') }}
                </h3>
                <div class="flex flex-wrap gap-3">
                    @foreach($settings->social_links ?? [] as $social)
                        @php
                            $label = $social['label'] ?? ucfirst($social['platform'] ?? '');
                        @endphp
                        <a href="{{ $social['url'] ?? '#' }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="{{ $label }}"
                           title="{{ $label }}"
                           class="flex size-10 items-center justify-center rounded-full bg-white/10 text-gray-300 transition hover:bg-brand hover:text-white">
                            <x-social-icon :platform="$social['platform'] ?? ''" class="size-5" />
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- ── Bottom bar ──────────────────────────────────────────── --}}
    <div class="border-t border-navy-700">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-4 py-4 text-xs text-gray-500 sm:flex-row">
            <span>{{ __('footer.copyright', ['year' => date('Y')]) }}</span>
            <div class="flex gap-4">
                <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated(app()->getLocale(), 'routes.privacy') }}"
                   class="transition hover:text-white">{{ __('footer.privacy') }}</a>
                <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated(app()->getLocale(), 'routes.terms') }}"
                   class="transition hover:text-white">{{ __('footer.terms') }}</a>
            </div>
        </div>
    </div>

</footer>
