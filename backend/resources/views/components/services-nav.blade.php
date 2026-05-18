{{--
    Services nav component
    ────────────────────────────────────────────────────────────
    Renders a locale-aware grid of services for use in desktop
    dropdown and mobile accordion. Falls back to the services
    index if the current locale has no translation for a service.

    Props:
      $linkClass  — CSS class(es) for each <a> tag
      $afterClick — Alpine expression to run on click (e.g. "servicesOpen = false")
--}}
@props([
    'linkClass'  => 'nav-dropdown-item',
    'afterClick' => '',
])

@php
    $locale   = app()->getLocale();
    $services = app(\Modules\Services\Services\ServiceService::class)->listServices();
@endphp

@foreach($services as $service)
    @php
        $slug = $service->getLocalizedRouteKey($locale);
        $url  = $slug
            ? \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated(
                $locale, 'routes.services.show', ['service' => $slug]
              )
            : \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getURLFromRouteNameTranslated(
                $locale, 'routes.services'
              );
    @endphp
    <a href="{{ $url }}"
       class="{{ $linkClass }}"
       @if($afterClick) @click="{{ $afterClick }}" @endif>
        @if($service->icon)
            <span class="nav-service-icon shrink-0">{!! $service->icon !!}</span>
        @endif
        <span>{{ $service->title }}</span>
    </a>
@endforeach
