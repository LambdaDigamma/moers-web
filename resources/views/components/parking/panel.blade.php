<a href="{{ route('parking-area.show', $parkingArea->slug) }}"
    class="block overflow-hidden bg-white rounded-lg shadow hover:bg-gray-50">
    <div class="px-4 py-5 lg:p-5">
        <div class="flex flex-row items-start justify-between space-x-3">
            <h3 class="text-lg font-semibold truncate">
                {{ $parkingArea->name }}
            </h3>
            <x-location.opening-state :state="$parkingArea->current_opening_state" />
        </div>
        <div class="flex flex-row items-end justify-between space-x-3 space-y-4">
            <div>
                {{-- <p class="text-xs font-medium text-gray-400 uppercase">
                    Frei
                </p> --}}
                <p>
                    <span class="text-xl font-semibold">
                        {{ $parkingArea->freeSites() }}
                    </span>
                    <span class="text-sm font-medium text-gray-500"> / </span>
                    <span class="text-sm font-medium text-gray-500">
                        {{ $parkingArea->capacity }} frei
                    </span>
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500">
                    @if ($parkingArea->updated_at)
                    {{ $parkingArea->updated_at->timezone('Europe/Berlin')->diffForHumans() }}
                    @endif
                </p>
            </div>
        </div>
    </div>
</a>