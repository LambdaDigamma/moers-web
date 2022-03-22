<x-card>
    <div class="flex flex-row items-center justify-between px-4 py-4 sm:px-4">
        <h2 id="parking-title" class="text-lg font-semibold text-gray-900">
            Parkleitsystem
        </h2>
        <div class="relative w-6 h-6 text-white bg-blue-600 rounded-sm">
            <div class="absolute inset-0 flex flex-col items-center justify-center font-semibold">
                <span>P</span>
            </div>
        </div>
    </div>
    <div class="border-t border-b border-gray-200">
        <div class="grid grid-cols-2">
            @foreach ($parkingAreas as $i => $parkingArea)
            <div
                class="flex flex-row justify-between px-4 py-2 border-gray-200 @if($i % 2 == 0) border-r @endif @if ($i <= $parkingAreas->count() - ($i % 2 == 0 ? 2 : 1)) border-b @endif">
                <p class="text-sm text-gray-900">
                    {{ $parkingArea->name }}
                </p>
                <span
                    class="font-mono inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                    {{ $parkingArea->freeSites() }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    <div class="flex flex-col px-4 pb-4 mt-4 justify-stretch sm:px-4">
        <a href="{{ route('parking-area.index') }}"
            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-gray-900 border border-transparent rounded-md shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
            Alle ansehen
        </a>
    </div>
</x-card>