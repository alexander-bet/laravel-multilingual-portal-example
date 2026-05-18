{{--
    Global lead-form popup modal.
    Always in the DOM (included in app.blade.php). Hidden via x-show when closed.

    Trigger from anywhere with plain JS (no Alpine context needed):
        window.dispatchEvent(new CustomEvent('lead-form:open'))
        window.dispatchEvent(new CustomEvent('lead-form:open', { detail: { preselect: 42 } }))
--}}
@php
    $titleParts = explode(':highlight', __('lead_form.title'));
@endphp

{{-- Outer shell: x-show controls everything; no pointer-events tricks needed --}}
<div
    x-data="leadForm({ source: 'popup', preselect: null, locale: '{{ app()->getLocale() }}' })"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-9999"
    role="dialog"
    aria-modal="true"
    aria-label="{{ __('lead_form.section_label') }}"
>
    {{-- Backdrop --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="absolute inset-0 bg-black/70 backdrop-blur-sm"
        aria-hidden="true"
    ></div>

    {{-- Flex wrapper — centers the panel on both axes --}}
    <div class="relative flex h-full items-center justify-center p-4 sm:p-6">

        {{-- Panel --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.stop
            data-modal-panel
            tabindex="-1"
            class="relative w-full max-w-2xl overflow-hidden rounded-2xl bg-[#0d1b2e] shadow-2xl outline-none"
        >
            {{-- Glow --}}
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_80%_60%_at_50%_120%,rgba(234,88,12,0.15),transparent)]"></div>

            {{-- Close button --}}
            <button
                type="button"
                @click="open = false"
                class="absolute inset-e-4 top-4 z-10 rounded-md p-1.5 text-slate-400 transition hover:bg-white/10 hover:text-white"
                aria-label="Close"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="relative max-h-[90vh] overflow-y-auto px-6 py-8 sm:px-8 sm:py-10">

                {{-- Heading --}}
                <div class="mb-3 h-px w-12 bg-orange-500"></div>
                <h2 class="mb-2 text-xl font-bold leading-snug text-white sm:text-2xl">
                    {{ $titleParts[0] ?? '' }}<span class="text-orange-500">{{ __('lead_form.title_highlight') }}</span>{{ $titleParts[1] ?? '' }}
                </h2>
                <p class="mb-6 text-sm leading-relaxed text-slate-300">
                    {{ __('lead_form.subtitle') }}
                </p>

                {{-- Success --}}
                <div
                    x-show="success"
                    x-cloak
                    x-transition
                    class="mb-4 flex items-center gap-3 rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-green-400"
                    role="alert"
                >
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-sm">{{ __('lead_form.success') }}</span>
                </div>

                {{-- Error --}}
                <div
                    x-show="error"
                    x-cloak
                    x-transition
                    class="mb-4 flex items-center gap-3 rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-red-400"
                    role="alert"
                >
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm">{{ __('lead_form.error') }}</span>
                </div>

                {{-- Form --}}
                <form x-show="!success" @submit.prevent="submit" novalidate>
                    <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-400">
                        {{ __('lead_form.section_label') }}
                    </p>

                    <div class="flex flex-col gap-3">

                        {{-- Service --}}
                        <div>
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

                        <div class="flex flex-col gap-3 sm:flex-row">

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

                            {{-- Phone --}}
                            <div class="relative flex-1">
                                <div
                                    class="flex rounded-md border border-slate-600 transition focus-within:border-orange-500 focus-within:ring-1 focus-within:ring-orange-500"
                                    :class="{ 'border-red-500': errors.phone }"
                                >
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
                                    class="absolute inset-x-0 top-full z-10 mt-1 overflow-hidden rounded-lg border border-slate-700 bg-[#0d1b2e] shadow-xl"
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
                                    <ul class="max-h-48 overflow-y-auto py-1" role="listbox">
                                        <template x-for="c in countries" :key="c.iso">
                                            <li
                                                role="option"
                                                :aria-selected="countryIso === c.iso"
                                                @click="selectCountry(c)"
                                                tabindex="0"
                                                @keydown.enter="selectCountry(c)"
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
                        </div>

                        {{-- Submit --}}
                        <button
                            type="submit"
                            :disabled="loading"
                            class="w-full rounded-md bg-orange-500 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-orange-600 active:scale-95 disabled:cursor-not-allowed disabled:opacity-70"
                        >
                            <span x-show="!loading">{{ __('lead_form.submit') }}</span>
                            <span x-show="loading" x-cloak class="flex items-center justify-center gap-2">
                                <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                </svg>
                                {{ __('lead_form.submitting') }}
                            </span>
                        </button>

                    </div>
                </form>

            </div>{{-- /scrollable inner --}}
        </div>{{-- /panel --}}
    </div>{{-- /flex wrapper --}}
</div>{{-- /outer shell --}}
