<x-layout.main>

    <div class="min-h-screen bg-gray-100">
        <x-regular-navigation-bar>
            <x-slot name="breadcrumbs">
                <x-breadcrumb-item href="{{ route('parking-area.index') }}" current>
                    Parkplätze
                </x-breadcrumb-item>
            </x-slot>
        </x-regular-navigation-bar>

        <main class="py-10">
            <div class="px-4 mx-auto sm:px-6 lg:px-8 max-w-7xl">

                <h2 class="text-xl font-bold text-gray-900">
                    Freie Parkplätze in Moers
                </h2>

                <div class="grid grid-cols-1 gap-6 mt-6 lg:grid-cols-3">
                    @foreach ($parkingAreas as $parkingArea)
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <div class="px-4 py-5 sm:p-5">
                            <div class="flex flex-row items-start justify-between space-x-3">
                                <h3 class="text-lg font-semibold">
                                    {{ $parkingArea->name }}
                                </h3>
                                <div>
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
                                </div>
                            </div>
                            <div class="flex flex-row items-end justify-between space-x-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-400 uppercase">
                                        Frei
                                    </p>
                                    <p>
                                        <span class="text-xl font-semibold">
                                            {{ $parkingArea->freeSites() }}

                                        </span>
                                        <span class="text-sm font-medium text-gray-500"> / </span>
                                        <span class="text-sm font-medium text-gray-500">
                                            {{ $parkingArea->capacity }}
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
                    </div>
                    @endforeach
                </div>
                {{-- <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                    <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                        <div class="flex flex-wrap items-center justify-between -mt-4 -ml-4 sm:flex-nowrap">
                            <div class="mt-4 ml-4">
                                <div class="flex items-center">
                                    <div>
                                        <h2 class="text-lg font-medium leading-6 text-gray-900">
                                            Parken in Moers
                                        </h2>
                                        <p class="text-sm text-gray-500">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-hidden bg-white">

                    </div>
                </div> --}}
            </div>
        </main>
        <x-footer>
        </x-footer>
</x-layout.main>