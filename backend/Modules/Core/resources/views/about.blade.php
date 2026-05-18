<x-layouts.app>

    @php
    $featureIcons = [
        // 0 — Verified suppliers catalogue
        '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z"/>',
        // 1 — Logistics & customs
        '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5a17.92 17.92 0 0 1-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"/>',
        // 2 — Legal support
        '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.97Zm-12.5 0L3.63 15.696c-.122.499.106 1.028.589 1.202a5.989 5.989 0 0 0 2.031.352 5.989 5.989 0 0 0 2.031-.352c.483-.174.711-.703.59-1.202L6.25 4.97Zm12.5 0a48.574 48.574 0 0 0-3 .52m-12.5-.52a48.574 48.574 0 0 1 3 .52"/>',
        // 3 — Quality control & packaging
        '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"/>',
        // 4 — Supplier verification
        '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>',
        // 5 — Business tours
        '<path stroke-linecap="round" stroke-linejoin="round" d="M20.893 13.393l-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.09-.15a2.25 2.25 0 0 1 2.37-1.048l1.178.236a1.125 1.125 0 0 0 1.302-.795l.208-.73a1.125 1.125 0 0 0-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 0 1-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 0 1-1.458-1.137l1.411-2.353a2.25 2.25 0 0 0 .286-.76m11.928 9.869A9 9 0 0 0 8.965 3.525m11.928 9.868A9 9 0 1 1 8.965 3.525"/>',
    ];
    @endphp

    {{-- ── Hero ───────────────────────────────────────────────────── --}}
    <section class="bg-gray-50 py-12 lg:py-20">
        <div class="mx-auto max-w-6xl px-4">
            <h1 class="mb-8 text-3xl text-center font-bold text-navy">{{ __('about.meta_title') }}</h1>
            <div class="flex flex-col items-center gap-10 lg:flex-row lg:gap-16">

                {{-- Logo --}}
                <div class="flex shrink-0 items-center justify-center lg:w-80">
                    <img
                        src="{{ asset('images/logo.svg') }}"
                        alt="Your Service Site"
                        class="w-56 lg:w-72"
                        width="288"
                        height="120"
                    >
                </div>

                {{-- Description --}}
                <div class="space-y-4 text-gray-700 leading-relaxed">
                    <p>{{ __('about.hero_p1') }}</p>
                    <p>{{ __('about.hero_p2') }}</p>
                </div>

            </div>
        </div>
    </section>

    {{-- ── What is CGH ─────────────────────────────────────────────── --}}
    <section class="bg-white py-14 lg:py-20">
        <div class="mx-auto max-w-6xl px-4">

            {{-- Heading --}}
            <h2 class="mb-6 text-center text-2xl font-bold uppercase tracking-wide text-navy lg:text-3xl">
                {{ __('about.what_is') }}
                <span class="text-brand">{{ __('about.what_is_highlight') }}</span>
            </h2>

            {{-- Intro text --}}
            <p class="mx-auto mb-12 max-w-3xl text-center text-gray-600 leading-relaxed">
                {{ __('about.what_description') }}
            </p>

            {{-- 3×2 feature grid --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach(__('about.features') as $i => $feature)
                <div class="flex items-start gap-4 border border-gray-100 bg-white p-5 shadow-sm transition hover:shadow-md border-b-4 hover:border-b-4 hover:border-b-brand">
                    {{-- Icon box --}}
                    <div class="shrink-0 bg-navy border-l-4 border-l-brand p-3">
                        <svg class="size-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            {!! $featureIcons[$i] ?? '' !!}
                        </svg>
                    </div>
                    {{-- Text --}}
                    <div>
                        <p class="font-semibold text-navy leading-snug">{{ $feature['title'] }}</p>
                        <p class="mt-1 text-sm text-gray-500">{{ $feature['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Geographic reach --}}
            <p class="mx-auto mt-12 max-w-3xl text-center text-sm text-gray-500 leading-relaxed">
                {{ __('about.what_footer') }}
            </p>
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
        </div>
    </section>

    {{-- ── Lead Form ───────────────────────────────────────────────── --}}
    <x-lead-form source="about_page" />

</x-layouts.app>
