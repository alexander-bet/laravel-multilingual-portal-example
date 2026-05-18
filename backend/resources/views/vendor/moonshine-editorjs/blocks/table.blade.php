<div class="overflow-x-auto my-6">
    <table class="w-full border-collapse text-sm">
        @foreach($data['content'] as $row)
        <tr class="border-b border-gray-200">
            @php $tag = ($loop->first && ($data['withHeadings'] ?? false)) ? 'th' : 'td'; @endphp
            @foreach($row as $cell)
            <{{ $tag }} class="{{ $tag === 'th' ? 'bg-gray-50 font-semibold text-left' : '' }} px-4 py-2">{!! $cell !!}</{{ $tag }}>
            @endforeach
        </tr>
        @endforeach
    </table>
</div>
