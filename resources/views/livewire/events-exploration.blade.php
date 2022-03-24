<div class="mt-20">

    <div class="pb-3 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
        <h1 class="text-lg font-bold leading-6 text-gray-900 md:text-xl">Veranstaltungen in Moers</h1>
    </div>

    <div class="pb-3 mt-3 overflow-x-auto border-b border-gray-200 no-scrollbar">
        <div class="flex flex-row space-x-4">
            @foreach ($categories as $item)
            <x-event.category-chip class="shrink-0" :image="$item['image']" text="{{ $item['category'] }}">
            </x-event.category-chip>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6 mt-4">
        <div class="col-span-2">
            @if ($search != null && $search != "")
            <x-card>
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

            {{-- <x-card>
            </x-card> --}}
            @endif
        </div>
        <x-card class="w-full col-span-1 divide-y divide-gray-200 place-self-start">
            <div class="relative">
                <x-heroicon-s-search class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400" />
                <input type="search" wire:model="search" id="event_search"
                    class="w-full h-12 pr-4 text-gray-800 placeholder-gray-400 bg-transparent border-0 pl-11 focus:ring-0 sm:text-sm"
                    placeholder="Veranstaltung suchen…">
            </div>
            {{-- <div class="p-4 space-y-2">
                <legend class="text-sm font-semibold text-gray-900">Zeitraum</legend>
                <button>
                    01.01. 10:00 - 05.01. 10:00
                </button>
            </div> --}}
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
                        <input id="offline" name="offline" type="checkbox" wire:model="only_free"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="offline" class="font-medium text-gray-700">Nur kostenlose Veranstaltungen</label>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
</div>