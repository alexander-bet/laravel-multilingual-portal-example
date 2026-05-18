<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ in_array(app()->getLocale(), ['ar', 'fa']) ? 'rtl' : 'ltr' }}"
    class="scroll-smooth"
>
<head>
    @meta_tags
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="icon" href="/images/favicon/favicon.ico">
    <link rel="manifest" href="/images/favicon/site.webmanifest">

    {{-- Almarai — RTL languages only (loaded from public/fonts, served by nginx/server) --}}
    @if(in_array(app()->getLocale(), ['ar', 'fa']))
    <style>
        @font-face {
            font-family: 'Almarai';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url('/fonts/almarai-400.woff2') format('woff2');
        }
        @font-face {
            font-family: 'Almarai';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url('/fonts/almarai-700.woff2') format('woff2');
        }
        :root { --font-sans: 'Almarai', ui-sans-serif, system-ui, sans-serif; }
        body  { font-family: 'Almarai', ui-sans-serif, system-ui, sans-serif; }
    </style>
    @endif

    {{-- Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Per-page head extras --}}
    @stack('head')
</head>
<body class="flex min-h-screen flex-col bg-white font-sans text-gray-800 antialiased">

    {{-- Alpine cloak prevention --}}
    <style>[x-cloak]{display:none!important}</style>

    {{-- Header --}}
    <x-header />

    {{-- Page content --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <x-footer />

    {{-- Mobile bottom bar --}}
    <x-mobile-bottom-bar />

    {{-- Global lead-form popup (triggered via $dispatch('lead-form:open')) --}}
    <x-lead-form-popup />

    {{-- Global modal slot (contact popup etc.) --}}
    @stack('modals')

    {{-- Per-page scripts registered via Meta package (e.g. Leaflet on contact page) --}}
    @meta_tags('footer')

    {{-- Per-page scripts that depend on Meta package libraries (must come after @meta_tags('footer')) --}}
    @stack('scripts')

</body>
</html>
