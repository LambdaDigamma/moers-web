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
            <x-card>
                <div class="overflow-hidden border-t border-l border-r border-gray-200 sm:rounded-t-lg">
                    <img src="{{ $parkingArea->getFirstMediaUrl('snapshot_light') }}" alt="Map" height="400" width="600"
                        class="overflow-hidden" />
                </div>
                <div class="flex items-center justify-between px-4 py-4 border-t border-gray-200 grow-0 sm:px-6">
                    <div>
                        <p class="text-xs font-semibold tracking-wider text-blue-500 uppercase">
                            Parkplatz
                        </p>
                        <h2 class="text-base font-semibold text-gray-900 truncate">
                            {{ $parkingArea->name }}
                        </h2>
                    </div>
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
            </x-card>

            <div class="px-4 py-5 overflow-hidden bg-white shadow sm:rounded-lg sm:p-6">
                <div class="flex flex-row justify-between">
                    <div>
                        <p>
                            <span class="text-xl font-semibold md:text-2xl">
                                {{ $parkingArea->freeSites() }}
                            </span>
                            <span class="text-sm font-medium text-gray-500 md:text-2xl"> / </span>
                            <span class="text-sm font-medium text-gray-500 md:text-2xl">
                                {{ $parkingArea->capacity }}
                            </span>
                        </p>
                        <p class="text-xs text-gray-500 md:text-sm">
                            @if ($parkingArea->updated_at)
                            {{ $parkingArea->updated_at->timezone('Europe/Berlin')->diffForHumans() }}
                            @endif
                        </p>
                    </div>
                    <x-location.opening-state :state="$parkingArea->current_opening_state" />
                </div>

                {{-- <x-location.opening-hours class="mt-4 border-t border-b border-gray-100">

                </x-location.opening-hours> --}}
            </div>
            <div class="flex flex-col overflow-hidden bg-white shadow sm:rounded-lg md:col-span-1">
                <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Belegung in den letzten 24h</h3>
                    {{-- <p class="mt-1 text-sm text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit
                        quam
                        corrupti
                        consectetur.
                    </p> --}}
                </div>
                <canvas id="recent_history_chart" width="400" height="400" class="px-2"></canvas>
                {{-- <div class="px-4 py-5 sm:p-6 grow">
                    <div class="relative flex items-end justify-between h-full space-x-2 min-h-[5rem]">
                        @foreach ($pastOccupancy['data'] as $occupancy)
                        <div class="bg-blue-500 rounded-lg grow"
                            style="height: {{ $occupancy->occupancy_rate * 100 }}%">

                        </div>
                        @endforeach
                    </div>
                </div> --}}
            </div>
        </div>
    </x-container>

    @push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"
        integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

    <script type="text/javascript">
        const ctx = document.getElementById('recent_history_chart');
        const myChart = new Chart(ctx, {
        type: 'line',
            data: {
                labels: [17,18,19,20,21,22,23,0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15],
                datasets: [{
                    label: 'Belegung',
                    data: [16.84,3.827273,1.05,1.05,1.05,1.05,1.05,1.05,1.05,1.05,1.05,1.05,1.05,2.7781819999999997,13.876363999999999,33.015454999999996,49.569091,64.07875,65.13125,62.019166999999996,56.076364,51.580000000000005],
                    fill: true,
                    tension: 0.5,
                    backgroundColor: [
                        'rgba(60, 130, 246, 0.2)',
                    ],
                    borderColor: [
                        'rgba(60, 130, 246, 0.8)',
                        // 'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value, index, ticks) {
                                return value + '%';
                            }
                        }
                    },
                    x: {
                        
                    }
                }
            }
        });

    </script>
    @endpush
</x-layout.main>