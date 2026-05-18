<x-layouts.app>

    {{-- ── Hero Slider ─────────────────────────────────────────────── --}}
    @if($featuredServices->isNotEmpty())
    <section
        x-data="{
            current: 0,
            total: {{ $featuredServices->count() }},
            autoplay: null,
            start() {
                this.autoplay = setInterval(() => this.next(), 6000);
            },
            next() { this.current = (this.current + 1) % this.total; },
            prev() { this.current = (this.current - 1 + this.total) % this.total; },
        }"
        x-init="start()"
        class="relative overflow-hidden bg-navy max-w-screen-2xl mx-auto lg:-mt-8"
        style="min-height: 560px;"
    >
        {{-- Slides --}}
        @foreach($featuredServices as $index => $service)
        @php
            $locale   = app()->getLocale();
            $image    = $service->getFirstMedia('cover');
            $imageUrl = $image ? ($image->getUrl('webp') ?: $image->getUrl()) : null;
            $slug     = $service->getLocalizedRouteKey($locale);
            $serviceUrl = $slug
                ? \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($locale, 'routes.services.show', ['service' => $slug])
                : \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($locale, 'routes.services');
        @endphp
        <div
            x-show="current === {{ $index }}"
            x-transition:enter="transition-opacity duration-700"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0"
            @if($index !== 0) style="display:none" @endif
        >
            @if($imageUrl)
            <img
                src="{{ $imageUrl }}"
                alt="{{ $service->title }}"
                class="absolute inset-0 h-full w-full object-cover"
                loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
            >
            @endif
            <div class="absolute inset-0 bg-navy/65"></div>

            <div class="relative mx-auto flex h-full max-w-6xl flex-col justify-center px-4 py-24 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <span class="mb-4 text-3xl font-bold leading-tight text-white sm:text-4xl lg:text-5xl">
                        {{ $service->title }}
                    </span>
                    @if($service->excerpt)
                    <p class="mb-8 text-base text-white/80 sm:text-lg">
                        {{ $service->excerpt }}
                    </p>
                    @endif
                    <div class="flex flex-wrap gap-4">
                        @if($slug)
                        <a href="{{ $serviceUrl }}" class="btn-primary">
                            {{ __('home.find_out_cost') }}
                        </a>
                        @endif
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('lead-form:open'))"
                           class="btn-outline border-white! text-white! hover:bg-white! hover:text-navy!">
                            {{ __('home.contact_us') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @if($featuredServices->count() > 1)
        <button
            @click="prev(); clearInterval(autoplay); start()"
            class="absolute inset-s-4 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/20 p-2 text-white backdrop-blur-sm transition hover:bg-white/40 focus:outline-none cursor-pointer"
            aria-label="{{ __('home.slider_prev') }}"
        >
            <svg class="size-5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button
            @click="next(); clearInterval(autoplay); start()"
            class="absolute inset-e-4 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/20 p-2 text-white backdrop-blur-sm transition hover:bg-white/40 focus:outline-none cursor-pointer"
            aria-label="{{ __('home.slider_next') }}"
        >
            <svg class="size-5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <div class="absolute bottom-6 inset-s-1/2 z-10 flex -translate-x-1/2 gap-2">
            @foreach($featuredServices as $index => $service)
            <button
                @click="current = {{ $index }}; clearInterval(autoplay); start()"
                :class="current === {{ $index }} ? 'bg-brand w-6' : 'bg-white/50 w-2'"
                class="h-2 rounded-full transition-all duration-300 focus:outline-none cursor-pointer"
                aria-label="{{ __('home.slider_goto', ['n' => $index + 1]) }}"
            ></button>
            @endforeach
        </div>
        @endif
    </section>
    @endif

    {{-- ── Services Carousel ───────────────────────────────────────── --}}
    @if($allServices->isNotEmpty())
    @php $locale = app()->getLocale(); @endphp
    <section class="mx-auto max-w-6xl px-4 py-12">
        <h1 class="text-2xl uppercase text-center text-navy lg:text-3xl">
            {{ __('home.our_services') }}
            <span class="block text-center text-lg lg:text-xl text-brand">{{ __('home.our_services_subtitle') }}</span>
        </h1>
        <div class="mb-8 flex items-center justify-end">
            <a href="{{ LaravelLocalization::localizeURL(route('services.index')) }}"
               class="shrink-0 text-sm font-semibold text-brand bg-linear-to-r from-brand to-brand bg-size-[0%_2px] bg-no-repeat bg-bottom hover:bg-size-[100%_2px] transition-[background-size] duration-300 ease-out">
                {{ __('home.all_services') }}
            </a>
        </div>

        <div
            class="glide"
            data-glide
            data-glide-per-view="3"
            data-glide-slide-count="{{ $allServices->count() }}"
        >
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @foreach($allServices as $service)
                    @php
                        $image    = $service->getFirstMedia('cover');
                        $imageUrl = $image ? ($image->getUrl('webp') ?: $image->getUrl()) : null;
                        $slug     = $service->getLocalizedRouteKey($locale);
                        $svcUrl   = $slug
                            ? \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($locale, 'routes.services.show', ['service' => $slug])
                            : \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($locale, 'routes.services');
                    @endphp
                    <li class="glide__slide">
                        <a href="{{ $svcUrl }}"
                           class="group block overflow-hidden bg-white shadow-sm ring-1 ring-gray-100 transition hover:shadow-md hover:ring-brand/30">
                            <div class="relative aspect-video overflow-hidden bg-navy/10">
                                @if($imageUrl)
                                    <img src="{{ $imageUrl }}"
                                         alt="{{ $service->title }}"
                                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                         loading="lazy">
                                @else
                                    <div class="flex h-full items-center justify-center bg-navy/5">
                                        <svg class="size-12 text-navy/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 21h18M6.75 3h10.5"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-navy transition group-hover:text-brand line-clamp-2">
                                    {{ $service->title }}
                                </h3>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            @if($allServices->count() > 1)
            <div class="mt-6 flex items-center justify-center gap-4" data-glide-el="controls">
                <button
                    class="flex size-10 items-center justify-center rounded-full border border-gray-300 text-navy transition hover:bg-brand hover:text-white hover:border-brand cursor-pointer"
                    data-glide-dir="<"
                    aria-label="{{ __('home.slider_prev') }}"
                >
                    <svg class="size-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button
                    class="flex size-10 items-center justify-center rounded-full border border-gray-300 text-navy transition hover:bg-brand hover:text-white hover:border-brand cursor-pointer"
                    data-glide-dir=">"
                    aria-label="{{ __('home.slider_next') }}"
                >
                    <svg class="size-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
            @endif
        </div>
    </section>
    @endif

    {{-- ── Personnel (Our Experts) ───────────────────────────────── --}}
    @if($personnel->isNotEmpty())
    <section class="mx-auto max-w-6xl px-4 py-12">
        <h2 class="mb-10 text-2xl uppercase text-center text-navy lg:text-3xl">
            {{ __('home.our_experts') }}
        </h2>

        @if($personnel->count() === 1)
        {{-- Single person: centred card, no carousel --}}
        @php
            $person   = $personnel->first();
            $photo    = $person->getFirstMedia('photo');
            $photoUrl = $photo ? ($photo->getUrl('webp') ?: $photo->getUrl()) : null;
        @endphp
        <div class="mx-auto max-w-xs">
            <div class="group relative overflow-hidden bg-gray-100 shadow-sm">
                <div class="aspect-3/4 overflow-hidden">
                    @if($photoUrl)
                        <img src="{{ $photoUrl }}" alt="{{ $person->name }}" class="h-full w-full object-cover" loading="lazy">
                    @endif
                </div>
                <div class="p-4 text-center uppercase">
                    <p class="font-semibold text-navy">{{ $person->name }}</p>
                    <p class="mt-1 text-sm text-gray-500">{{ $person->position }}</p>
                </div>
            </div>
        </div>

        @elseif($personnel->count() <= 3)
        {{-- 2–3 people on desktop: static grid, no carousel needed --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-{{ $personnel->count() }}">
            @foreach($personnel as $person)
            @php
                $photo    = $person->getFirstMedia('photo');
                $photoUrl = $photo ? ($photo->getUrl('webp') ?: $photo->getUrl()) : null;
            @endphp
            <div class="group relative overflow-hidden bg-gray-100 shadow-sm">
                <div class="aspect-3/4 overflow-hidden">
                    @if($photoUrl)
                        <img src="{{ $photoUrl }}" alt="{{ $person->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    @else
                        <div class="flex h-full items-center justify-center bg-navy/10">
                            <svg class="size-16 text-navy/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="absolute text-center uppercase inset-x-0 bottom-0 translate-y-full bg-navy border-b-2 border-b-brand p-4 transition-transform duration-300 group-hover:translate-y-0">
                    <p class="font-semibold text-white leading-tight">{{ $person->name }}</p>
                    <p class="mt-1 text-sm text-white/80">{{ $person->position }}</p>
                </div>
                <div class="p-4 text-center uppercase group-hover:opacity-0 transition-opacity duration-200">
                    <p class="font-semibold text-navy leading-tight">{{ $person->name }}</p>
                    <p class="mt-1 text-sm text-gray-500">{{ $person->position }}</p>
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- 4+ people: Glide carousel --}}
        <div
            class="glide"
            data-glide
            data-glide-per-view="3"
            data-glide-slide-count="{{ $personnel->count() }}"
        >
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    @foreach($personnel as $person)
                    @php
                        $photo    = $person->getFirstMedia('photo');
                        $photoUrl = $photo ? ($photo->getUrl('webp') ?: $photo->getUrl()) : null;
                    @endphp
                    <li class="glide__slide">
                        <div class="group relative overflow-hidden bg-gray-100 shadow-sm">
                            <div class="aspect-3/4 overflow-hidden">
                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}"
                                         alt="{{ $person->name }}"
                                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                         loading="lazy">
                                @else
                                    <div class="flex h-full items-center justify-center bg-navy/10">
                                        <svg class="size-16 text-navy/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="absolute text-center uppercase inset-x-0 bottom-0 translate-y-full bg-navy border-b-2 border-b-brand p-4 transition-transform duration-300 group-hover:translate-y-0">
                                <p class="font-semibold text-white leading-tight">{{ $person->name }}</p>
                                <p class="mt-1 text-sm text-white/80">{{ $person->position }}</p>
                            </div>
                            <div class="p-4 text-center uppercase group-hover:opacity-0 transition-opacity duration-200">
                                <p class="font-semibold text-navy leading-tight">{{ $person->name }}</p>
                                <p class="mt-1 text-sm text-gray-500">{{ $person->position }}</p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-6 flex items-center justify-center gap-4" data-glide-el="controls">
                <button
                    class="flex size-10 items-center justify-center rounded-full border border-gray-300 text-navy transition hover:bg-brand hover:text-white hover:border-brand cursor-pointer"
                    data-glide-dir="<"
                    aria-label="{{ __('home.slider_prev') }}"
                >
                    <svg class="size-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button
                    class="flex size-10 items-center justify-center rounded-full border border-gray-300 text-navy transition hover:bg-brand hover:text-white hover:border-brand cursor-pointer"
                    data-glide-dir=">"
                    aria-label="{{ __('home.slider_next') }}"
                >
                    <svg class="size-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif
    </section>
    @endif

    {{-- ── Pricing Plans ───────────────────────────────────────────── --}}
    @if($pricingPlans->isNotEmpty())
    @php
        $pricingWords     = explode(' ', __('home.pricing_title'));
        $pricingPlain     = Str::upper($pricingWords[0] ?? '');
        $pricingHighlight = Str::upper(implode(' ', array_slice($pricingWords, 1)));
    @endphp
    <section class="bg-gray-50 py-14 lg:py-20">
        <div class="mx-auto max-w-6xl px-4">
            <h2 class="mb-12 text-2xl uppercase text-center text-navy lg:text-3xl">
                {{ $pricingPlain }}<span class="text-brand"> {{ $pricingHighlight }}</span>
            </h2>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-{{ min(4, $pricingPlans->count()) }}">
                @foreach($pricingPlans as $plan)
                <div class="flex flex-col overflow-hidden shadow-md">
                    <div class="bg-navy px-6 py-5 text-center">
                        <h3 class="text-lg font-bold uppercase tracking-wide text-white">
                            {{ $plan->name }}
                        </h3>
                    </div>
                    <div class="bg-gray-100 px-6 py-5 text-center">
                        <span class="text-3xl font-bold text-navy lg:text-4xl">{{ $plan->price }}</span>
                    </div>
                    <div class="flex flex-1 flex-col bg-white px-6 py-6">
                        <ul class="flex-1 space-y-3">
                            @foreach($plan->featuresArray() as $feature)
                            <li class="flex items-start gap-3 text-sm text-gray-700">
                                <svg class="mt-0.5 size-4 shrink-0 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $feature }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <button
                        type="button"
                        onclick="window.dispatchEvent(new CustomEvent('lead-form:open'))"
                        class="block w-full bg-brand px-4 py-3 text-center text-sm font-bold uppercase tracking-widest text-white transition hover:bg-brand/90 active:scale-95 cursor-pointer"
                    >
                        {{ __('home.pricing_cta') }}
                    </button>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ── News Carousel ────────────────────────────────────────────── --}}
    @if($newsArticles->isNotEmpty())
    @php
        $locale     = app()->getLocale();
        $newsSlug   = \Modules\Blog\Models\Category::whereHas('translations', fn($q) =>
            $q->where('locale', 'ru')->where('slug', 'novosti')
        )->first()?->getLocalizedRouteKey($locale);
        $newsCatUrl = $newsSlug
            ? \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($locale, 'routes.blog.category', ['category' => $newsSlug])
            : \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($locale, 'routes.blog');
    @endphp
    <section class="bg-gray-50 py-12">
        <div class="mx-auto max-w-6xl px-4">
            <h2 class="text-2xl text-center uppercase text-navy lg:text-3xl">
                {!! __('home.news_title', [
                    'event1' => '<span class="text-brand">' . __('home.news_title_event1') . '</span>',
                    'event2' => '<span class="text-brand">' . __('home.news_title_event2') . '</span>',
                ]) !!}
            </h2>
            <div class="mb-8 flex justify-end">
                <a href="{{ $newsCatUrl }}"
                   class="text-sm font-semibold text-brand bg-linear-to-r from-brand to-brand bg-size-[0%_2px] bg-no-repeat bg-bottom hover:bg-size-[100%_2px] transition-[background-size] duration-300 ease-out">
                    {{ __('home.news_all') }}
                </a>
            </div>

            <div
                class="glide"
                data-glide
                data-glide-per-view="3"
                data-glide-slide-count="{{ $newsArticles->count() }}"
            >
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        @foreach($newsArticles as $article)
                        @php
                            $artSlug     = $article->getLocalizedRouteKey($locale);
                            $artUrl      = $artSlug
                                ? \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($locale, 'routes.blog.show', ['article' => $artSlug])
                                : \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated($locale, 'routes.blog');
                            $artImage    = $article->getFirstMedia('featured');
                            $artImageUrl = $artImage ? ($artImage->getUrl('webp') ?: $artImage->getUrl()) : null;
                        @endphp
                        <li class="glide__slide">
                            <a href="{{ $artUrl }}"
                               class="group flex h-full flex-col overflow-hidden bg-white shadow-sm ring-1 ring-gray-100 transition hover:shadow-md hover:ring-brand/30">
                                <div class="relative aspect-video overflow-hidden bg-navy/10">
                                    @if($artImageUrl)
                                        <img src="{{ $artImageUrl }}"
                                             alt="{{ $article->title }}"
                                             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                             loading="lazy">
                                    @else
                                        <div class="flex h-full items-center justify-center bg-navy/5">
                                            <svg class="size-12 text-navy/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-1 flex-col p-4">
                                    <h3 class="line-clamp-2 font-semibold text-navy transition group-hover:text-brand">
                                        {{ $article->title }}
                                    </h3>
                                    @if($article->published_at)
                                        <p class="mt-auto pt-3 text-xs text-gray-400">
                                            {{ $article->published_at->translatedFormat('j F Y') }}
                                        </p>
                                    @endif
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                @if($newsArticles->count() > 1)
                <div class="mt-6 flex items-center justify-center gap-4" data-glide-el="controls">
                    <button
                        class="flex size-10 items-center justify-center rounded-full border border-gray-300 text-navy transition hover:bg-brand hover:text-white hover:border-brand cursor-pointer"
                        data-glide-dir="<"
                        aria-label="{{ __('home.slider_prev') }}"
                    >
                        <svg class="size-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button
                        class="flex size-10 items-center justify-center rounded-full border border-gray-300 text-navy transition hover:bg-brand hover:text-white hover:border-brand cursor-pointer"
                        data-glide-dir=">"
                        aria-label="{{ __('home.slider_next') }}"
                    >
                        <svg class="size-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    <x-lead-form source="inline_home" />

</x-layouts.app>
