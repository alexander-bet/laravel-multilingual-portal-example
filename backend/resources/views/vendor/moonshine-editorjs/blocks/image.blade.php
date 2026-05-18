@php
    $classes = '';
    if (!empty($data['stretched'])) $classes .= ' image--stretched';
    if (!empty($data['withBorder'])) $classes .= ' image--bordered';
    if (!empty($data['withBackground'])) $classes .= ' image--backgrounded';
@endphp

<figure class="my-6 {{ $classes }}">
    <img src="{{ $data['file']['url'] ?? '' }}" alt="{{ $data['caption'] ?? '' }}"
         class="rounded-lg mx-auto max-w-full">
    @if (!empty($data['caption']))
        <figcaption class="text-center text-gray-500 text-sm mt-2">{{ $data['caption'] }}</figcaption>
    @endif
</figure>
