<x-layout.main>
    <x-regular-navigation-bar>
        <x-slot name="breadcrumbs">
            <x-breadcrumb-item href="{{ route('parking-area.index') }}">
                Parkplätze
            </x-breadcrumb-item>
            <x-breadcrumb-item href="{{ route('parking-area.index') }}" current>
                {{ $parkingArea->name }}
            </x-breadcrumb-item>
        </x-slot>
    </x-regular-navigation-bar>
    <x-container regular fluidmobile>
        <div class="grid grid-cols-1 gap-6 pb-8 sm:pt-12 sm:grid-cols-2 md:grid-cols-3">
            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="overflow-hidden border-t border-l border-r border-gray-200 sm:rounded-t-lg">
                    <img src="{{ $imageUrl }}" alt="Map" height="400" width="600" class="overflow-hidden" />
                </div>
                <div class="flex items-center justify-between px-4 py-4 border-t border-gray-200 grow-0 sm:px-6">
                    <h2 class="text-base font-semibold text-gray-900 truncate">
                        {{ $parkingArea->name }}
                    </h2>
                    <div>
                        <button
                            onclick='Livewire.emit("openModal", "navigation-panel", {{ json_encode(["lat" => $lat, "lng" => $lng]) }})'
                            class="border border-transparent inline-flex p-2 px-3 text-blue-500 rounded-full bg-blue-50 space-x-1.5 items-center focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            title="Navigation starten">
                            <span class="text-xs font-semibold">Navigation</span>
                            <x-heroicon-s-arrow-right class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            </div>

            <div class="px-4 py-5 overflow-hidden bg-white shadow sm:rounded-lg sm:p-6">
                @if ($parkingArea->isOpen())
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-green-100 text-green-800">
                    Geöffnet
                </span>
                @elseif($parkingArea->isClosed())
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-red-100 text-red-800">
                    Geschlossen
                </span>
                @else
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-gray-100 text-gray-800">
                    Unbekannt
                </span>
                @endif

                <p>
                    <span class="text-xl font-semibold">
                        {{ $parkingArea->freeSites() }}
                    </span>
                    <span class="text-sm font-medium text-gray-500"> / </span>
                    <span class="text-sm font-medium text-gray-500">
                        {{ $parkingArea->capacity }}
                    </span>
                </p>
                <p class="text-xs text-gray-500">
                    @if ($parkingArea->updated_at)
                    {{ $parkingArea->updated_at->timezone('Europe/Berlin')->diffForHumans() }}
                    @endif
                </p>
            </div>
            <div class="overflow-hidden bg-white divide-y divide-gray-200 shadow sm:rounded-lg md:col-span-3">
                <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Belegung in den letzten 24 Stunden</h3>
                    <p class="mt-1 text-sm text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit quam
                        corrupti
                        consectetur.</p>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="relative flex items-end justify-between space-x-2 h-80">
                        @foreach ($pastOccupancy['data'] as $occupancy)
                        <div class="bg-blue-500 rounded-lg grow"
                            style="height: {{ $occupancy->occupancy_rate * 100 }}%">

                        </div>
                        {{-- {{ $occupancy->occupancy_rate }}
                        {{ $occupancy->hour }} --}}
                        @endforeach
                        {{-- <div class="absolute inset-0 p-4 ">
                            <div class="border-t border-b border-gray-100">

                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>

        </div>
    </x-container>
</x-layout.main>