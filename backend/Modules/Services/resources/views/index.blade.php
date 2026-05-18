<x-layouts.app>

    <section class="mx-auto max-w-6xl px-4 py-12 lg:py-16">

        {{-- Page header --}}
        <div class="mb-10 max-w-xl">
            <h1 class="mb-4 text-3xl font-bold text-navy lg:text-4xl">{{ __('nav.services') }}</h1>
            <p class="text-gray-500">{{ __('services.index_description') }}</p>
        </div>

        {{-- Services grid --}}
        <div class="grid gap-px bg-gray-100 sm:grid-cols-2 lg:grid-cols-4">
            @forelse($services as $i => $service)
                @php
                    $locale = app()->getLocale();
                    $slug   = $service->getLocalizedRouteKey($locale);
                    $url    = $slug
                        ? \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated(
                            $locale, 'routes.services.show', ['service' => $slug]
                          )
                        : \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated(
                            $locale, 'routes.services'
                          );
                    $featured = $i === 0;
                @endphp
                <a href="{{ $url }}"
                   class="group flex flex-col items-center gap-4 p-8 text-center transition-colors
                          {{ $featured
                              ? 'bg-navy text-white'
                              : 'bg-white text-navy hover:bg-navy hover:text-white' }}">

                    {{-- Icon --}}
                    @if($service->icon)
                        <span class="service-card-icon
                                     {{ $featured ? 'text-brand' : 'text-brand group-hover:text-brand' }}">
                            {!! $service->icon !!}
                        </span>
                    @else
                        {{-- Placeholder circle when no icon set --}}
                        <span class="flex size-12 items-center justify-center rounded-full
                                     {{ $featured ? 'bg-navy-800' : 'bg-gray-100 group-hover:bg-navy-800' }}">
                            <svg class="size-6 {{ $featured ? 'text-brand' : 'text-navy group-hover:text-brand' }}"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42
                                         15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655
                                         5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164
                                         1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004
                                         3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091
                                         1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909
                                         7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745
                                         1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>
                            </svg>
                        </span>
                    @endif

                    <h2 class="text-sm font-bold uppercase tracking-widest">
                        {{ $service->title }}
                    </h2>

                    @if($service->excerpt)
                        <p class="mt-1 text-xs leading-relaxed transition-opacity duration-200">
                            {{ $service->excerpt }}
                        </p>
                    @endif

                    <span class="mt-auto text-xs font-semibold uppercase tracking-wide text-brand
                                 underline underline-offset-4 opacity-0 transition-opacity duration-200
                                 {{ $featured ? 'opacity-100!' : 'group-hover:opacity-100' }}">
                        {{ __('services.learn_more') }}
                    </span>
                </a>
            @empty
                <p class="col-span-4 py-12 text-center text-gray-500">{{ __('services.no_services') }}</p>
            @endforelse
        </div>

    </section>

</x-layouts.app>
