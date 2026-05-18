<x-layouts.app>

    <section class="bg-gray-50 py-12 lg:py-16">
        <div class="mx-auto max-w-3xl px-4">

            <h1 class="mb-2 text-2xl font-bold uppercase text-navy lg:text-3xl">
                {{ __($langKey . '.title') }}
            </h1>
            <p class="mb-10 text-sm text-gray-400">
                {{ __($langKey . '.last_updated') }}
            </p>

            @foreach(__($langKey . '.sections') as $section)
            <div class="mb-8">
                <h2 class="mb-3 text-base font-semibold text-navy">
                    {{ $section['title'] }}
                </h2>
                @foreach($section['paragraphs'] as $para)
                <p class="mb-3 text-sm leading-relaxed text-gray-600">{{ $para }}</p>
                @endforeach
            </div>
            @endforeach

        </div>
    </section>

</x-layouts.app>
