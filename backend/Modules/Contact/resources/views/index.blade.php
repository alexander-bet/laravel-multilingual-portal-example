<x-layouts.app>

    <section class="mx-auto max-w-6xl px-4 py-12">
        <h1 class="mb-8 text-3xl font-bold text-navy">{{ __('nav.contact') }}</h1>

        <div class="grid gap-12 lg:grid-cols-2">

            {{-- Contact info --}}
            <div class="space-y-6 text-gray-700">

                {{-- Phones --}}
                @if($settings->phones)
                    <div class="flex items-start gap-3">
                        <svg class="mt-1 size-5 shrink-0 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-navy">{{ __('header.phone_label') }}</p>
                            @foreach($settings->phones as $phone)
                                <a href="tel:{{ preg_replace('/\s+/', '', $phone['number'] ?? '') }}"
                                   class="block hover:text-brand transition">
                                    {{ $phone['number'] ?? '' }}
                                    @if(!empty($phone['label']))
                                        <span class="text-sm text-gray-500">({{ $phone['label'] }})</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Emails --}}
                @if($settings->emails)
                    <div class="flex items-start gap-3">
                        <svg class="mt-1 size-5 shrink-0 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-navy">Email</p>
                            @foreach($settings->emails as $emailEntry)
                                <a href="mailto:{{ $emailEntry['email'] ?? '' }}"
                                   class="block hover:text-brand transition">
                                    {{ $emailEntry['email'] ?? '' }}
                                    @if(!empty($emailEntry['label']))
                                        <span class="text-sm text-gray-500">({{ $emailEntry['label'] }})</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Social links --}}
                @if($settings->social_links)
                    <div class="flex items-start gap-3">
                        <svg class="mt-1 size-5 shrink-0 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-navy">{{ __('contact.follow_us') }}</p>
                            <div class="flex flex-wrap gap-4 mt-2">
                                @foreach($settings->social_links as $social)
                                    @php
                                        $label = $social['label'] ?? ucfirst($social['platform'] ?? '');
                                    @endphp
                                    <a href="{{ $social['url'] ?? '#' }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       aria-label="{{ $label }}"
                                       title="{{ $label }}"
                                       class="text-gray-500 hover:text-brand transition">
                                        <x-social-icon :platform="$social['platform'] ?? ''" class="size-6" />
                                        <span class="sr-only">{{ $label }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Addresses --}}
                @if($settings->addresses)
                    @foreach($settings->addresses as $address)
                        <div class="flex items-start gap-3">
                            <svg class="mt-1 size-5 shrink-0 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div>
                                @if(!empty($address['is_main']))
                                    <p class="font-semibold text-navy">{{ __('header.address_label') }}</p>
                                @endif
                                <p>
                                    @if(app()->getLocale() === 'en' && !empty($address['address_en']))
                                        {{ $address['address_en'] }}
                                    @else
                                        {{ $address['address'] ?? '' }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>

            {{-- Contact form --}}
            <div>
                @if(session('success'))
                    <div class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-700 border border-green-200">
                        {{ __('contact.success') }}
                    </div>
                @endif

                <form action="{{ LaravelLocalization::localizeURL(route('contact.store')) }}"
                      method="POST"
                      x-data="{ loading: false }"
                      @submit="loading = true"
                      class="space-y-4">
                    @csrf

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('contact.name') }} *</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="field @error('name') border-red-400 @enderror"
                               placeholder="{{ __('contact.name_placeholder') }}">
                        @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="field @error('email') border-red-400 @enderror"
                               placeholder="you@example.com">
                        @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('contact.phone') }}</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                               class="field" placeholder="+7 900 000-00-00">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">{{ __('contact.message') }} *</label>
                        <textarea name="message" rows="5"
                                  class="field @error('message') border-red-400 @enderror"
                                  placeholder="{{ __('contact.message_placeholder') }}">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center" :disabled="loading">
                        <span x-show="!loading">{{ __('contact.submit') }}</span>
                        <span x-show="loading" x-cloak>{{ __('contact.sending') }}…</span>
                    </button>
                </form>
            </div>

        </div>

        {{-- Map --}}
        @php
            $mapAddresses = collect($settings->addresses ?? [])
                ->filter(fn($a) => !empty($a['lat']) && !empty($a['lng']))
                ->values();
        @endphp

        @if($mapAddresses->isNotEmpty())
            <div class="mt-12">
                <div id="contact-map" class="h-80 w-full rounded-xl overflow-hidden shadow"></div>
            </div>

            @push('scripts')
            <script>
                (function () {
                    const appLocale = '{{ app()->getLocale() }}';

                    // Fix Leaflet default marker icon paths when served from /vendor/leaflet/
                    delete L.Icon.Default.prototype._getIconUrl;
                    L.Icon.Default.mergeOptions({
                        iconUrl:       '/vendor/leaflet/images/marker-icon.png',
                        iconRetinaUrl: '/vendor/leaflet/images/marker-icon-2x.png',
                        shadowUrl:     '/vendor/leaflet/images/marker-shadow.png',
                    });

                    const addresses = @json($mapAddresses);

                    const map = L.map('contact-map');

                    // Gaode (Amap) tiles — accessible in mainland China
                    L.tileLayer('https://webrd0{s}.is.autonavi.com/appmaptile?lang=zh_cn&size=1&scale=1&style=8&x={x}&y={y}&z={z}', {
                        subdomains: '1234',
                        attribution: '© AutoNavi',
                        maxZoom: 18,
                    }).addTo(map);

                    const markers = addresses.map(function (addr) {
                        const lat = parseFloat(addr.lat);
                        const lng = parseFloat(addr.lng);
                        const label = (appLocale === 'en' && addr.address_en) ? addr.address_en : addr.address;
                        const marker = L.marker([lat, lng]).addTo(map);
                        if (label) marker.bindPopup(label);
                        return marker;
                    });

                    if (markers.length === 1) {
                        const pos = markers[0].getLatLng();
                        map.setView(pos, 15);
                    } else {
                        const group = L.featureGroup(markers);
                        map.fitBounds(group.getBounds().pad(0.2));
                    }
                })();
            </script>
            @endpush
        @endif

    </section>

</x-layouts.app>
