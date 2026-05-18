{{--
    Lead capture form — inline variant.

    Props:
      $source     string    Identifies where the form is embedded
                            e.g. 'inline_home', 'inline_about', 'inline_services'
      $preselect  int|null  Pre-select a service by its ID

    $services is injected automatically by the View Composer
    in ContactServiceProvider.
--}}
@props([
    'source'    => 'unknown',
    'preselect' => null,
])

@php
    $titleParts = explode(':highlight', __('lead_form.title'));
@endphp

<section
    x-data="leadForm({ source: '{{ $source }}', preselect: {{ $preselect ?? 'null' }}, locale: '{{ app()->getLocale() }}' })"
    class="relative overflow-hidden bg-[#0d1b2e] py-14 md:py-20"
    aria-label="{{ __('lead_form.section_label') }}"
>
    {{-- Subtle radial glow --}}
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_80%_60%_at_50%_120%,rgba(234,88,12,0.12),transparent)]"></div>

    <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

        {{-- Heading --}}
        <div class="mb-4 h-px w-16 bg-orange-500"></div>
        <h2 class="mb-3 text-2xl font-bold leading-snug text-white md:text-3xl lg:text-4xl">
            {{ $titleParts[0] ?? '' }}<span class="text-orange-500">{{ __('lead_form.title_highlight') }}</span>{{ $titleParts[1] ?? '' }}
        </h2>

        <p class="mb-8 max-w-3xl text-sm leading-relaxed text-slate-300 md:text-base">
            {{ __('lead_form.subtitle') }}
        </p>

        {{-- Success message --}}
        <div
            x-show="success"
            x-cloak
            x-transition
            class="mb-6 flex items-center gap-3 rounded-lg border border-green-500/30 bg-green-500/10 px-5 py-4 text-green-400"
            role="alert"
        >
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ __('lead_form.success') }}</span>
        </div>

        {{-- Server / network error --}}
        <div
            x-show="error"
            x-cloak
            x-transition
            class="mb-6 flex items-center gap-3 rounded-lg border border-red-500/30 bg-red-500/10 px-5 py-4 text-red-400"
            role="alert"
        >
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ __('lead_form.error') }}</span>
        </div>

        {{-- Form (hidden after success) --}}
        <form
            x-show="!success"
            @submit.prevent="submit"
            novalidate
        >
            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-400">
                {{ __('lead_form.section_label') }}
            </p>

            <div class="flex flex-col gap-3 sm:flex-row">

                {{-- Service dropdown --}}
                <div class="flex-1">
                    <select
                        x-model="serviceId"
                        class="w-full rounded-md border border-slate-600 bg-transparent px-4 py-3 text-sm text-slate-100 outline-none transition focus:border-orange-500 focus:ring-1 focus:ring-orange-500 [&>option]:bg-[#0d1b2e] [&>option]:text-slate-100"
                        aria-label="{{ __('lead_form.select_service') }}"
                    >
                        <option value="">{{ __('lead_form.select_service') }}</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}">{{ $service->title }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.service_id" x-text="errors.service_id?.[0]" x-cloak class="mt-1 text-xs text-red-400"></p>
                </div>

                {{-- Email --}}
                <div class="flex-1">
                    <input
                        x-model="email"
                        type="email"
                        inputmode="email"
                        autocomplete="email"
                        placeholder="{{ __('lead_form.email_placeholder') }}"
                        :class="{ 'border-red-500': errors.email }"
                        class="w-full rounded-md border border-slate-600 bg-transparent px-4 py-3 text-sm text-slate-100 placeholder-slate-500 outline-none transition focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                        aria-label="{{ __('lead_form.email_placeholder') }}"
                    >
                    <p x-show="errors.email" x-text="errors.email?.[0]" x-cloak class="mt-1 text-xs text-red-400"></p>
                </div>

                {{-- Phone with country code picker --}}
                <div class="relative flex-1">
                    <div
                        class="flex rounded-md border border-slate-600 transition focus-within:border-orange-500 focus-within:ring-1 focus-within:ring-orange-500"
                        :class="{ 'border-red-500': errors.phone }"
                    >
                        {{-- Country code toggle --}}
                        <button
                            type="button"
                            @click="pickerOpen = !pickerOpen"
                            class="flex shrink-0 items-center gap-1.5 border-e border-slate-600 px-3 py-3 text-sm text-slate-100 outline-none transition hover:bg-white/5"
                            aria-haspopup="listbox"
                            :aria-expanded="pickerOpen"
                        >
                            <span x-text="countryFlag" class="text-base leading-none"></span>
                            <span x-text="dialCode" class="font-mono text-xs text-slate-300"></span>
                            <svg class="h-3 w-3 text-slate-500 transition-transform" :class="{ 'rotate-180': pickerOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Phone number --}}
                        <input
                            :value="phone"
                            @input="sanitizePhone($event)"
                            type="tel"
                            inputmode="numeric"
                            autocomplete="tel"
                            placeholder="{{ __('lead_form.phone_placeholder') }}"
                            class="min-w-0 flex-1 bg-transparent px-3 py-3 text-sm text-slate-100 placeholder-slate-500 outline-none"
                            aria-label="{{ __('lead_form.phone_placeholder') }}"
                        >
                    </div>

                    {{-- Country picker dropdown --}}
                    <div
                        x-show="pickerOpen"
                        x-cloak
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        @click.outside="pickerOpen = false"
                        @keydown.escape.window="pickerOpen = false"
                        class="absolute inset-s-0 top-full z-50 mt-1 w-64 overflow-hidden rounded-lg border border-slate-700 bg-[#0d1b2e] shadow-xl"
                        role="listbox"
                    >
                        <div class="border-b border-slate-700 p-2">
                            <input
                                x-model="countrySearch"
                                data-country-search
                                type="text"
                                placeholder="{{ __('lead_form.search_country') }}"
                                class="w-full rounded bg-slate-800 px-3 py-1.5 text-xs text-slate-100 placeholder-slate-500 outline-none focus:ring-1 focus:ring-orange-500"
                            >
                        </div>
                        <ul class="max-h-52 overflow-y-auto py-1" role="listbox">
                            <template x-for="c in countries" :key="c.iso">
                                <li
                                    role="option"
                                    :aria-selected="countryIso === c.iso"
                                    @click="selectCountry(c)"
                                    @keydown.enter="selectCountry(c)"
                                    tabindex="0"
                                    class="flex cursor-pointer items-center gap-2.5 px-3 py-2 text-sm text-slate-200 transition hover:bg-white/5"
                                    :class="{ 'bg-orange-500/10 text-orange-400': countryIso === c.iso }"
                                >
                                    <span x-text="c.flag" class="text-base leading-none"></span>
                                    <span x-text="c.name" class="flex-1 truncate"></span>
                                    <span x-text="c.dialCode" class="font-mono text-xs text-slate-500"></span>
                                </li>
                            </template>
                            <li x-show="countries.length === 0" class="px-3 py-4 text-center text-xs text-slate-500">—</li>
                        </ul>
                    </div>

                    <p x-show="errors.phone" x-text="errors.phone?.[0]" x-cloak class="mt-1 text-xs text-red-400"></p>
                </div>

                {{-- Submit button --}}
                <button
                    type="submit"
                    :disabled="loading"
                    class="shrink-0 rounded-md bg-orange-500 px-8 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-orange-600 active:scale-95 disabled:cursor-not-allowed disabled:opacity-70"
                >
                    <span x-show="!loading">{{ __('lead_form.submit') }}</span>
                    <span x-show="loading" x-cloak class="flex items-center gap-2">
                        <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        {{ __('lead_form.submitting') }}
                    </span>
                </button>

            </div>{{-- /flex row --}}
        </form>

    </div>
</section>
