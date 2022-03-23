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

                <div class="flex flex-row justify-between">
                    <h2 class="text-xl font-bold text-gray-900">
                        Freie Parkplätze in Moers
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($parkingAreas as $parkingArea)
                    <a href="{{ route('parking-area.show', $parkingArea->slug) }}"
                        class="block overflow-hidden bg-white rounded-lg shadow hover:bg-gray-50">
                        <div class="px-4 py-5 lg:p-5">
                            <div class="flex flex-row items-start justify-between space-x-3">
                                <h3 class="text-lg font-semibold truncate">
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
                    </a>
                    @endforeach
                </div>
            </div>
        </main>
</x-layout.main>