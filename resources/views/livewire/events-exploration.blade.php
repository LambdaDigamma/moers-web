<div class="mt-20">

    <div class="pb-3 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
        <h1 class="text-lg font-bold leading-6 text-gray-900 md:text-xl">Veranstaltungen in Moers</h1>
    </div>

    {{-- <div class="pb-3 mt-3 overflow-x-auto border-b border-gray-200 no-scrollbar">
        <div class="flex flex-row space-x-4">
            @foreach ($categories as $item)
            <x-event.category-chip class="shrink-0" :image="$item['image']" text="{{ $item['category'] }}">
            </x-event.category-chip>
            @endforeach
        </div>
    </div> --}}

    <div class="grid grid-cols-3 gap-6 mt-4">
        <div class="w-full col-span-1 place-self-start">
            <x-card class="divide-y divide-gray-200">
                <div class="relative">
                    <x-heroicon-s-search class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400" />
                    <input type="search" wire:model.debounce.300ms="search" id="event_search"
                        class="w-full h-12 pr-4 text-gray-800 placeholder-gray-400 bg-transparent border-0 pl-11 focus:ring-0 sm:text-sm"
                        placeholder="Veranstaltung suchen…">
                </div>
                {{-- <div class="p-4 space-y-2">
                    <legend class="text-sm font-semibold text-gray-900">Zeitraum</legend>
                    <button>
                        01.01. 10:00 - 05.01. 10:00
                    </button>
                </div> --}}
                <div class="p-4 space-y-2">
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700">Kategorie</label>
                        <div class="flex mt-1 rounded-md shadow-sm">
                            <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                <select id="category" name="category" wire:model="filterCategory"
                                    class="block w-full border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 rounded-l-md sm:text-sm">
                                    <option selected value="null">Kein Filter</option>
                                    @foreach ($categories as $item)
                                    <option value="{{ $item['category'] }}">
                                        {{ $item['category'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" wire:click="setCategoryFilter(null)"
                                class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-700 border border-gray-300 rounded-r-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-heroicon-s-x class="w-4 h-4 text-gray-400" />
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-4">
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
                <div class="p-4 space-y-2">
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
            </x-card>
            {{-- <div class="flex flex-row flex-wrap mt-4 space-x-4">
                @foreach ($categories as $item)
                <x-event.category-chip class="shrink-0" :image="$item['image']" text="{{ $item['category'] }}">
                </x-event.category-chip>
                @endforeach
            </div> --}}
        </div>
        <div class="col-span-2">
            @if ($searchActive)
            {{-- Search results --}}
            <x-card class="divide-y divide-gray-200">
                @foreach ($filteredEvents as $event)
                <x-event.row :event="$event" />
                @endforeach
                @if ($filteredEvents->isEmpty())
                <div class="flex flex-col items-center justify-center">
                    <div class="relative block w-full p-12 text-center rounded-lg">
                        <x-heroicon-o-emoji-sad class="w-12 h-12 mx-auto text-gray-400"></x-heroicon-o-emoji-sad>
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
            </x-card>
            @else
            {{-- Today --}}
            <div class="space-y-4">
                <x-card class="">
                    <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                        <h2 class="text-lg font-semibold leading-6 text-gray-900">Heutige Veranstaltungen</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach ($todayUpcoming as $event)
                        <x-event.row :event="$event">
                        </x-event.row>
                        @endforeach
                    </div>
                </x-card>
                <div class="pt-px pb-4 pr-px overflow-x-auto no-scrollbar">
                    <div class="flex flex-row space-x-4">
                        @foreach ($categories as $item)
                        <x-event.category-chip wire:click="setCategoryFilter('{{ $item['category' ]}}')"
                            class="shrink-0" :image="$item['image']" text="{{ $item['category'] }}">
                        </x-event.category-chip>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>