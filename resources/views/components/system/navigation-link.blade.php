<a href="{{ $route }}"
    class="block py-2 pl-3 pr-4 text-base font-medium border-l-4 @if ($active) text-blue-700 border-blue-500 bg-blue-50 @else text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 border-transparent @endif">
    {{ $slot }}
</a>