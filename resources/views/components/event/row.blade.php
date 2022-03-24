<a href="{{ route('events.show', $event->id) }}" class="block hover:bg-gray-50">
    <div class="flex items-center px-4 py-4 sm:px-4">
        <div class="flex-1 min-w-0 sm:flex sm:items-center sm:justify-between">
            <div class="truncate">
                <div class="flex text-sm">
                    <p class="font-medium text-gray-900 truncate">
                        {{ $event->name }}
                    </p>
                </div>
                <div class="flex mt-0">
                    <div class="flex items-center text-sm text-gray-500">
                        <p>
                            <time datetime="2020-01-07">
                                {{ $date }}
                            </time>
                            <span> • </span>
                            <span>{{ $event->extras['location'] }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-shrink-0 ml-5">
            <!-- Heroicon name: solid/chevron-right -->
            <svg class="w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd" />
            </svg>
        </div>
    </div>
</a>