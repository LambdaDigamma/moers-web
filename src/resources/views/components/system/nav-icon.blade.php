<a href="{{ $href }}" title="{{ $title }}"
    class="inline-flex items-center justify-center w-10 h-10 transition border border-gray-100 rounded-lg shadow-sm hover:bg-gray-50 @if($active) ring-2 ring-blue-400 @endif">
    <div class="w-5 h-5 text-gray-700">
        {{ $slot }}
    </div>
    <span class="sr-only">{{ $title }}</span>
</a>