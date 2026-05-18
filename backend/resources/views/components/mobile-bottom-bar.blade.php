{{--
    Mobile bottom navigation bar
    ─────────────────────────────────────────────────────────────
    Fixed 5-icon bar visible only on mobile (hidden lg:hidden).
    Icons: Home, Services, Blog, Contact, Phone
--}}
<nav class="fixed inset-x-0 bottom-0 z-40 flex items-center justify-around border-t border-gray-200 bg-white px-2 py-2 lg:hidden"
     aria-label="{{ __('header.nav_label') }}">

    {{-- Home --}}
    <a href="{{ LaravelLocalization::localizeURL(route('blog.index')) }}"
       class="flex flex-col items-center gap-0.5 px-3 py-1 text-xs text-gray-500 transition hover:text-brand">
        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75V21a.75.75 0 01-.75.75H15.75A.75.75 0 0115 21v-4.5h-6V21a.75.75 0 01-.75.75H3.75A.75.75 0 013 21V9.75z"/>
        </svg>
        <span>{{ __('nav.home') }}</span>
    </a>

    {{-- Services --}}
    <a href="{{ LaravelLocalization::localizeURL(route('services.index')) }}"
       class="flex flex-col items-center gap-0.5 px-3 py-1 text-xs text-gray-500 transition hover:text-brand">
        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/>
        </svg>
        <span>{{ __('nav.services') }}</span>
    </a>

    {{-- Blog --}}
    <a href="{{ LaravelLocalization::localizeURL(route('blog.index')) }}"
       class="flex flex-col items-center gap-0.5 px-3 py-1 text-xs text-gray-500 transition hover:text-brand">
        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
        </svg>
        <span>{{ __('nav.blog') }}</span>
    </a>

    {{-- Contact --}}
    <a href="{{ LaravelLocalization::localizeURL(route('contact.index')) }}"
       class="flex flex-col items-center gap-0.5 px-3 py-1 text-xs text-gray-500 transition hover:text-brand">
        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
        </svg>
        <span>{{ __('nav.contact') }}</span>
    </a>

    {{-- Phone / CTA --}}
    <a href="tel:+861880760438"
       class="flex flex-col items-center gap-0.5 px-3 py-1 text-xs text-brand transition hover:text-brand-600">
        <span class="flex size-6 items-center justify-center rounded-full bg-brand text-white">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
        </span>
        <span>{{ __('header.phone_label') }}</span>
    </a>

</nav>

{{-- Push page content above the bar so it's never hidden behind it --}}
<div class="h-16 lg:hidden" aria-hidden="true"></div>
