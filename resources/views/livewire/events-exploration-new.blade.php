<div class="">
    <div class="relative w-full overflow-auto bg-gradient-to-r from-sky-800 to-cyan-600 h-80">
        <img src="/images/hero/veranstaltung.jpg" alt="" class="object-cover w-full h-full" aria-hidden="true" />
        <div class="absolute top-0 bottom-0 left-0 right-0 flex flex-col items-center justify-center bg-black/40 z-1">
            <h1 class="-mt-20 text-xl font-bold text-white lg:text-4xl">Veranstaltungen in Moers</h1>
        </div>
    </div>
    <div class="relative max-w-5xl mx-auto sm:px-6 lg:px-8">
        <x-card class="-mt-24 bg-white divide-y divide-gray-200 shadow-lg">
            <div class="relative bg-white">
                <x-heroicon-s-search class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400" />
                <input type="search" wire:model.debounce.300ms="search" id="event_search"
                    class="w-full h-12 pr-4 font-medium text-gray-800 placeholder-gray-400 bg-transparent border-0 pl-11 focus:ring-0 sm:text-sm lg:text-lg"
                    placeholder="Veranstaltung suchen…">
            </div>
            <div class="px-4 py-4 overflow-x-auto no-scrollbar">
                <div class="flex flex-row space-x-4">
                    @foreach ($categories as $item)
                    <?php
                    if ($item['category'] == $category) {
                        $class = "border-2 border-blue-500 shrink-0";
                    } else {
                        $class = "border-2 border-transparent shrink-0";
                    }
                    ?>
                    <x-event.category-chip wire:click="setCategoryFilter('{{ $item['category' ]}}')"
                        class="{{ $class }}" text="{{ $item['category'] }}" :image="$item['image']">
                    </x-event.category-chip>
                    @endforeach
                </div>
            </div>
            <div class="grid divide-gray-200 md:divide-x md:grid-cols-3">
                <div class="p-4 lg:p-6">
                    <fieldset class="space-y-2">
                        <legend class="text-sm font-semibold text-gray-900">Durchführungsform</legend>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="offline" name="offline" type="checkbox" wire:model="attendance_offline"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="offline" class="font-medium text-gray-700">In Präsenz</label>
                                </div>
                            </div>
                            <div class="relative flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="online" name="online" type="checkbox" wire:model="attendance_online"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="online" class="font-medium text-gray-700">Online</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="p-4 space-y-2 lg:p-6">
                    <legend class="text-sm font-semibold text-gray-900">Preis</legend>
                    <div class="relative flex items-start">
                        <div class="flex items-center h-5">
                            <input id="only_free" name="only_free" type="checkbox" wire:model="only_free"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="only_free" class="font-medium text-gray-700">
                                Nur kostenlose Veranstaltungen
                            </label>
                        </div>
                    </div>
                </div>
                <div class="p-4">

                </div>
            </div>
            @if ($searchActive)
            <div class="border-t border-gray-200">
                <div class="px-4 py-2 text-sm font-semibold text-left text-gray-900 bg-gray-50 sm:px-6">
                    Suchergebnisse
                </div>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach ($filteredEvents as $event)
                <?php
                            $class = $loop->odd ? 'bg-white' : 'bg-gray-50'
                        ?>
                <x-event.row :event="$event" class="{{ $class }}">
                </x-event.row>
                @endforeach
                @if ($filteredEvents->isEmpty())
                <div class="flex flex-col items-center justify-center">
                    <div class="relative block w-full p-12 text-center rounded-lg">
                        <x-heroicon-o-emoji-sad class="w-12 h-12 mx-auto text-gray-400">
                        </x-heroicon-o-emoji-sad>
                        <span class="block mt-2 text-sm font-medium text-gray-900">
                            Es gibt keine Ergebnisse für Deine Suche.
                        </span>
                    </div>
                    <button wire:click="resetSearch"
                        class="flex items-center justify-center w-full py-1.5 text-sm font-semibold text-red-500 bg-red-50 hover:underline">
                        Aktive Suche zurücksetzen
                    </button>
                </div>
                @endif
                @if ($filteredEvents->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $filteredEvents->render() }}
                </div>
                @endif
            </div>
            @endif
        </x-card>

        <div class="mt-20">
            <x-plain-section-header id="search_results" class="px-6">
                <span class="">
                    Heutige Veranstaltungen
                </span>
            </x-plain-section-header>

            <div class="grid grid-cols-3 gap-6 mt-4">
                <div class="col-span-3">
                    <div class="space-y-4">
                        <x-card class="shadow-lg">
                            @if (! $today->isEmpty())
                            <div class="divide-y divide-gray-200">
                                @foreach ($today as $event)
                                <?php
                                $class = $loop->odd ? 'bg-white' : 'bg-gray-50'
                                ?>
                                <x-event.row :event="$event" class="{{ $class }}">
                                </x-event.row>
                                @endforeach
                            </div>
                            @else
                            <div class="flex flex-row items-center justify-center p-6 py-8 bg-white">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <x-heroicon-o-sparkles class="w-10 h-10 text-yellow-400" />
                                    <p class="text-center text-gray-700">
                                        Huch, heute finden keine Veranstaltungen statt… <br />
                                        Aber mach Dir trotzdem einen schönen Tag!
                                    </p>
                                </div>
                            </div>
                            @endif
                            @if ($today->hasPages())
                            <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                                {{ $today->render() }}
                            </div>
                            @endif
                        </x-card>
                    </div>
                </div>
                {{-- <div class="w-full col-span-1 place-self-start"></div> --}}
            </div>
        </div>

        @if (! $longTermEvents->isEmpty())
        <div class="mt-20">
            <x-plain-section-header id="long_term" class="px-6">
                <span class="">
                    Länger in Moers
                </span>
            </x-plain-section-header>
            <div class="grid grid-cols-3 gap-6 mt-4">
                <div class="col-span-3">
                    <div class="space-y-4">
                        <x-card class="shadow-lg">
                            <div class="divide-y divide-gray-200">
                                @foreach ($longTermEvents as $event)
                                <?php
                                    $class = $loop->odd ? 'bg-white' : 'bg-gray-50'
                                ?>
                                <x-event.row :event="$event" class="{{ $class }}">
                                </x-event.row>
                                @endforeach
                            </div>
                        </x-card>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
