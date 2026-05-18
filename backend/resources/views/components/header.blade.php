{{--
    Header component
    ─────────────────────────────────────────────────────────────
    Alpine state (x-data on <header>):
      mobileOpen  — mobile nav drawer
      servicesOpen — Services dropdown
      blogOpen    — Blog dropdown
      langOpen    — Language switcher dropdown
--}}
@php
    $headerSettings  = \Modules\Core\Models\Setting::instance();
    $headerPhone     = collect($headerSettings->phones ?? [])->first();
    $headerEmail     = collect($headerSettings->emails ?? [])->first();
    $headerTelegram  = collect($headerSettings->social_links ?? [])
        ->first(fn($s) => strtolower($s['platform'] ?? '') === 'telegram');
@endphp

<header x-data="{
    mobileOpen: false,
    servicesOpen: false,
    blogOpen: false,
    langOpen: false,
    searchOpen: false,
    searchQuery: '',
    searchResults: { articles: [], services: [] },
    searchLoading: false,
    searchTimer: null,
    searchUrl: '{{ LaravelLocalization::localizeURL(route('search')) }}',
    openSearch() {
        this.searchOpen = true;
        this.$nextTick(() => this.$refs.searchInput?.focus());
    },
    closeSearch() {
        this.searchOpen = false;
        this.searchQuery = '';
        this.searchResults = { articles: [], services: [] };
    },
    debouncedSearch() {
        clearTimeout(this.searchTimer);
        if (this.searchQuery.length < 2) {
            this.searchResults = { articles: [], services: [] };
            return;
        }
        this.searchLoading = true;
        this.searchTimer = setTimeout(async () => {
            try {
                const res = await fetch(this.searchUrl + '?q=' + encodeURIComponent(this.searchQuery));
                this.searchResults = await res.json();
            } finally {
                this.searchLoading = false;
            }
        }, 300);
    },
    get hasResults() {
        return this.searchResults.articles.length > 0 || this.searchResults.services.length > 0;
    },
    get showEmpty() {
        return !this.searchLoading && this.searchQuery.length >= 2 && !this.hasResults;
    },
}" @keydown.escape.window="mobileOpen = false; servicesOpen = false; blogOpen = false; langOpen = false; closeSearch()" class="z-10">

    {{-- ── Top info bar ──────────────────────────────────── --}}
    <div class="hidden max-w-6xl mx-auto border-b border-gray-100 bg-white lg:block">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-14 text-sm text-gray-600">

            {{-- Left: address + email --}}
            <div class="flex items-center gap-6">
                <a href="{{ LaravelLocalization::localizeURL('/contact') }}" class="flex items-center gap-1.5 transition hover:text-brand"> 
                    <svg class="size-5 shrink-0 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <div class="inline-flex flex-col">
                    <span class="font-medium text-gray-800">{{ __('header.address_label') }}:</span>
                    <span>{{ __('header.address') }}</span>
                    </div>
                </a>
                @if($headerEmail)
                <a href="mailto:{{ $headerEmail['email'] ?? '' }}" class="flex items-center gap-1.5 transition hover:text-brand">
                    <svg class="size-5 shrink-0 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <div class="inline-flex flex-col">
                        <span class="font-medium text-gray-800">{{ __('header.email_label') }}:</span>
                        <span dir="ltr">{{ $headerEmail['email'] ?? '' }}</span>
                    </div>
                </a>
                @endif
            </div>

            {{-- Center: logo (desktop info bar) --}}
            @if(LaravelLocalization::localizeURL(route('home')) !== url()->current())
                <a href="{{ LaravelLocalization::localizeURL('/') }}" class="absolute left-1/2 -translate-x-1/2 flex flex-col items-center gap-1">
                    <img src="{{ asset('images/logo-mobile.svg') }}" alt="Your Service Site" class="h-16 w-auto">
                    <span class="text-xs font-medium tracking-wide text-gray-500">{{ config('app.name') }}</span>
                </a>
            @else
                <div class="absolute left-1/2 -translate-x-1/2 flex flex-col items-center gap-1">
                    <img src="{{ asset('images/logo-mobile.svg') }}" alt="Your Service Site" class="h-16 w-auto">
                    <span class="text-xs font-medium tracking-wide text-gray-500">{{ config('app.name') }}</span>
                </div>
            @endif
            {{-- Right: phone + telegram --}}
            <div class="flex items-center gap-6">
                @if($headerPhone)
                <a href="tel:{{ preg_replace('/\s+/', '', $headerPhone['number'] ?? '') }}"
                   class="flex items-center gap-1.5 transition hover:text-brand">
                    <svg class="size-5 shrink-0 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <div class="inline-flex flex-col">
                        <span class="font-medium text-gray-800">{{ __('header.phone_label') }}:</span>
                        <span dir="ltr">{{ $headerPhone['number'] ?? '' }}</span>
                    </div>
                </a>
                @endif
                @if($headerTelegram)
                @php
                    $tgUrl    = $headerTelegram['url'] ?? '';
                    // Extract @handle from t.me URLs, otherwise show the stored label
                    $tgHandle = preg_match('#t\.me/([^/?]+)#i', $tgUrl, $m)
                        ? '@' . $m[1]
                        : ($headerTelegram['label'] ?? 'Telegram');
                @endphp
                <a href="{{ $tgUrl }}"
                   target="_blank" rel="noopener noreferrer"
                   class="flex items-center gap-1.5 transition hover:text-brand">
                    <x-social-icon platform="telegram" class="size-5 shrink-0 text-brand" />
                    <div class="inline-flex flex-col">
                        <span class="font-medium text-gray-800">{{ __('header.telegram_label') }}:</span>
                        <span dir="ltr">{{ $tgHandle }}</span>
                    </div>
                </a>
                @endif
            </div>

        </div>
    </div>

    {{-- ── Main nav bar ───────────────────────────────────── --}}
    <nav class="bg-white lg:bg-navy text-navy max-w-6xl mx-auto" aria-label="{{ __('header.nav_label') }}">
        <div class="mx-auto flex items-center pl-4 rtl:pl-0 rtl:pr-4 h-16">

            {{-- Mobile: logo (nav bar) --}}
            <a href="{{ LaravelLocalization::localizeURL('/') }}" class="flex gap-1me-4 py-3 lg:hidden">
                <img src="{{ asset('images/logo-mobile.svg') }}" alt="Your Service Site" class="h-8 w-auto" width="32" height="32">
                <div class="text-center">
                    <span class="text-sm font-semibold">Your Service Site</span>
                    <span class="block text-[0.55rem] text-gray-500">Bridging China & the World</span>
                </div>
            </a>

            {{-- Desktop nav links --}}
            <div class="hidden flex-1 items-center lg:flex">

                {{-- Home --}}
                <a href="{{ LaravelLocalization::localizeURL('/') }}"
                   class="flex items-center px-3 py-4 text-sm font-medium text-white/80 transition hover:text-white">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75V21a.75.75 0 01-.75.75H15.75V15h-7.5v6.75H3.75A.75.75 0 013 21V9.75z"/>
                    </svg>
                </a>

                {{-- About --}}
                <a href="{{ LaravelLocalization::getURLFromRouteNameTranslated(app()->getLocale(), 'routes.about') }}"
                   class="px-3 py-4 text-sm font-medium uppercase tracking-wide text-white/80 transition hover:text-white">
                    {{ __('nav.about') }}
                </a>

                {{-- Services dropdown --}}
                <div class="relative" @click.away="servicesOpen = false">
                    <button @click="servicesOpen = !servicesOpen"
                            class="flex items-center gap-1 px-3 py-4 text-sm font-medium uppercase tracking-wide text-white/80 transition hover:text-white cursor-pointer"
                            :aria-expanded="servicesOpen">
                        {{ __('nav.services') }}
                        <svg class="size-3.5 transition-transform duration-200" :class="servicesOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="servicesOpen"
                         x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-1"
                         class="nav-dropdown-panel w-160 grid grid-cols-3 gap-px p-2 inset-s-0">
                        <x-services-nav
                            link-class="nav-service-item"
                            after-click="servicesOpen = false"
                        />
                    </div>
                </div>

                {{-- Blog dropdown --}}
                <div class="relative" @click.away="blogOpen = false">
                    <button @click="blogOpen = !blogOpen"
                            class="flex items-center gap-1 px-3 py-4 text-sm font-medium uppercase tracking-wide text-white/80 transition hover:text-white cursor-pointer"
                            :aria-expanded="blogOpen">
                        {{ __('nav.blog') }}
                        <svg class="size-3.5 transition-transform duration-200" :class="blogOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="blogOpen"
                         x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-1"
                         class="nav-dropdown-panel w-56">
                        <a href="{{ LaravelLocalization::localizeURL(route('blog.index')) }}"
                           class="nav-dropdown-item" @click="blogOpen = false">
                            {{ __('nav.all_articles') }}
                        </a>
                        @foreach(app(\Modules\Blog\Services\ArticleService::class)->listCategories() as $category)
                            @php
                                $catSlug = $category->getLocalizedRouteKey(app()->getLocale());
                                $catUrl = $catSlug
                                    ? LaravelLocalization::getURLFromRouteNameTranslated(app()->getLocale(), 'routes.blog.category', ['category' => $catSlug])
                                    : LaravelLocalization::getURLFromRouteNameTranslated(app()->getLocale(), 'routes.blog');
                            @endphp
                            <a href="{{ $catUrl }}"
                               class="nav-dropdown-item" @click="blogOpen = false">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Contact --}}
                <a href="{{ LaravelLocalization::localizeURL(route('contact.index')) }}"
                   class="px-3 py-4 text-sm font-medium uppercase tracking-wide text-white/80 transition hover:text-white">
                    {{ __('nav.contact') }}
                </a>

            </div>

            {{-- Right side: search + lang switcher + CTA --}}
            <div class="ms-auto flex items-center gap-1 h-full">

                {{-- Search --}}
                <button @click="openSearch()"
                        class="h-full p-2 text-navy lg:text-white transition hover:bg-brand hover:text-white cursor-pointer"
                        aria-label="{{ __('header.search') }}">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
                    </svg>
                </button>

                {{-- Language switcher --}}
                <div class="relative h-full" @click.away="langOpen = false">
                    <button @click="langOpen = !langOpen"
                            class="flex items-center gap-1 px-2 py-1.5 h-full text-sm font-semibold uppercase text-navy lg:text-white transition hover:bg-brand hover:text-white cursor-pointer"
                            :aria-expanded="langOpen">
                        {{ strtoupper(app()->getLocale()) }}
                        <svg class="size-3 transition-transform duration-200" :class="langOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="langOpen"
                         x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="nav-dropdown-panel end-0 start-auto w-32">
                        @foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties)
                            @php
                                // For model pages (articles, services, categories) the controller
                                // shares $localizedUrls with correct per-locale slugs via view()->share().
                                // Pass as redirect_to so lang.switch uses the right URL instead of
                                // naively swapping the locale prefix (which would keep the wrong slug).
                                $switchUrl = route('lang.switch', ['locale' => $locale]);
                                if (!empty($localizedUrls[$locale])) {
                                    $switchUrl .= '?redirect_to=' . urlencode($localizedUrls[$locale]);
                                }
                            @endphp
                            <a href="{{ $switchUrl }}"
                               rel="alternate"
                               hreflang="{{ $locale }}"
                               class="nav-dropdown-item flex items-center justify-between"
                               @click="langOpen = false">
                                <span>{{ $properties['native'] }}</span>
                                @if($locale === app()->getLocale())
                                    <svg class="size-3 text-brand" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.172l7.879-7.879a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- CTA button --}}
                <button type="button" onclick="window.dispatchEvent(new CustomEvent('lead-form:open'))"
                   class="btn-primary ms-2 rounded-none h-full hidden items-center gap-2 lg:inline-flex cursor-pointer">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    {{ __('nav.cta') }}
                </button>

                {{-- Mobile hamburger --}}
                <button @click="mobileOpen = !mobileOpen"
                        class="rounded p-2 text-navy transition hover:bg-navy-800 hover:text-white lg:hidden"
                        :aria-expanded="mobileOpen"
                        aria-label="{{ __('header.menu') }}">
                    <svg x-show="!mobileOpen" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" x-cloak class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

            </div>
        </div>

        {{-- ── Mobile drawer ─────────────────────────────── --}}
        <div x-show="mobileOpen"
             x-cloak
             x-collapse
             class="border-t border-navy-800 lg:hidden">
            <div class="space-y-0.5 px-4 py-3 bg-navy-800">

                <a href="{{ LaravelLocalization::localizeURL('/') }}"
                   class="block rounded px-3 py-2.5 text-sm font-medium text-white/80 hover:bg-navy-800 hover:text-white"
                   @click="mobileOpen = false">
                    {{ __('nav.home') }}
                </a>

                <a href="{{ LaravelLocalization::getURLFromRouteNameTranslated(app()->getLocale(), 'routes.about') }}"
                   class="block rounded px-3 py-2.5 text-sm font-medium text-white/80 hover:bg-navy-800 hover:text-white"
                   @click="mobileOpen = false">
                    {{ __('nav.about') }}
                </a>

                {{-- Mobile: Services accordion --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex w-full items-center justify-between rounded px-3 py-2.5 text-sm font-medium text-white/80 hover:bg-navy-800 hover:text-white">
                        {{ __('nav.services') }}
                        <svg class="size-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="ps-4">
                        <x-services-nav
                            link-class="nav-service-item-mobile"
                            after-click="mobileOpen = false"
                        />
                    </div>
                </div>

                {{-- Mobile: Blog accordion --}}
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex w-full items-center justify-between rounded px-3 py-2.5 text-sm font-medium text-white/80 hover:bg-navy-800 hover:text-white">
                        {{ __('nav.blog') }}
                        <svg class="size-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="ps-4">
                        <a href="{{ LaravelLocalization::localizeURL(route('blog.index')) }}"
                           class="block rounded px-3 py-2 text-sm text-white/70 hover:bg-navy-800 hover:text-white"
                           @click="mobileOpen = false">
                            {{ __('nav.all_articles') }}
                        </a>
                        @foreach(app(\Modules\Blog\Services\ArticleService::class)->listCategories() as $category)
                            @php
                                $catSlug = $category->getLocalizedRouteKey(app()->getLocale());
                                $catUrl  = $catSlug
                                    ? LaravelLocalization::getURLFromRouteNameTranslated(app()->getLocale(), 'routes.blog.category', ['category' => $catSlug])
                                    : LaravelLocalization::getURLFromRouteNameTranslated(app()->getLocale(), 'routes.blog');
                            @endphp
                            <a href="{{ $catUrl }}"
                               class="block rounded px-3 py-2 text-sm text-white/70 hover:bg-navy-800 hover:text-white"
                               @click="mobileOpen = false">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ LaravelLocalization::localizeURL(route('contact.index')) }}"
                   class="block rounded px-3 py-2.5 text-sm font-medium text-white/80 hover:bg-navy-800 hover:text-white"
                   @click="mobileOpen = false">
                    {{ __('nav.contact') }}
                </a>

                {{-- Mobile CTA --}}
                <div class="pt-2">
                    <button type="button" onclick="window.dispatchEvent(new CustomEvent('lead-form:open'))"
                       class="btn-primary w-full justify-center"
                       @click="mobileOpen = false">
                        {{ __('nav.cta') }}
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{-- ── Search overlay ────────────────────────────────── --}}
    <div
        x-show="searchOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex flex-col bg-navy/97"
        @click.self="closeSearch()"
    >
        {{-- Header row inside popup --}}
        <div class="flex items-center gap-4 px-4 py-4 sm:px-8">
            {{-- Input --}}
            <div class="relative flex-1">
                <svg class="absolute inset-y-0 inset-s-4 my-auto size-5 text-navy/40 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
                </svg>
                <input
                    type="search"
                    x-ref="searchInput"
                    x-model="searchQuery"
                    @input="debouncedSearch()"
                    placeholder="{{ __('header.search_placeholder') }}"
                    class="w-full bg-white py-3 ps-12 pe-4 text-lg text-navy placeholder-navy/40 outline-none ring-1 ring-white/20 focus:ring-brand"
                    autocomplete="off"
                >
                {{-- Spinner --}}
                <svg x-show="searchLoading" class="absolute inset-y-0 inset-e-4 my-auto size-5 animate-spin text-brand" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
            </div>
            {{-- Close --}}
            <button @click="closeSearch()" class="shrink-0 p-2 text-white/40 transition hover:text-brand cursor-pointer" aria-label="{{ __('header.search') }}">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Results --}}
        <div class="flex-1 overflow-y-auto px-4 pb-8 sm:px-8">

            {{-- No results message --}}
            <p x-show="showEmpty" class="mt-8 text-center text-white/50">
                {{ __('header.search_no_results') }}
            </p>

            {{-- Articles --}}
            <template x-if="searchResults.articles.length > 0">
                <div class="mt-6">
                    <h3 class="mb-3 text-xs font-semibold uppercase tracking-widest text-brand">
                        {{ __('header.search_articles') }}
                    </h3>
                    <div class="space-y-2">
                        <template x-for="item in searchResults.articles" :key="item.url">
                            <a :href="item.url"
                               @click="closeSearch()"
                               class="flex items-center gap-4 rounded-lg p-3 transition hover:bg-white/10">
                                <div x-show="item.image" class="size-12 shrink-0 overflow-hidden rounded bg-white/10">
                                    <img :src="item.image" :alt="item.title" class="h-full w-full object-cover">
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate font-medium text-white" x-text="item.title"></p>
                                    <p x-show="item.excerpt" class="mt-0.5 truncate text-sm text-white/50" x-text="item.excerpt"></p>
                                </div>
                                <svg class="ms-auto size-4 shrink-0 text-white/30 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </template>
                    </div>
                </div>
            </template>

            {{-- Services --}}
            <template x-if="searchResults.services.length > 0">
                <div class="mt-6">
                    <h3 class="mb-3 text-xs font-semibold uppercase tracking-widest text-brand">
                        {{ __('header.search_services') }}
                    </h3>
                    <div class="space-y-2">
                        <template x-for="item in searchResults.services" :key="item.url">
                            <a :href="item.url"
                               @click="closeSearch()"
                               class="flex items-center gap-4 rounded-lg p-3 transition hover:bg-white/10">
                                <div class="min-w-0 flex-1">
                                    <p class="truncate font-medium text-white" x-text="item.title"></p>
                                    <p x-show="item.excerpt" class="mt-0.5 truncate text-sm text-white/50" x-text="item.excerpt"></p>
                                </div>
                                <svg class="ms-auto size-4 shrink-0 text-white/30 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </template>
                    </div>
                </div>
            </template>

        </div>
    </div>

</header>
