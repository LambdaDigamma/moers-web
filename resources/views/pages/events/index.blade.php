<x-layout.main>
    <x-regular-navigation-bar>
        <x-slot name="breadcrumbs">
            <x-breadcrumb-item href="{{ route('events.index') }}">
                Veranstaltungen
            </x-breadcrumb-item>
        </x-slot>
    </x-regular-navigation-bar>

    <livewire:events-exploration />

    <div class="relative max-w-5xl pb-12 mx-auto sm:px-6 lg:px-8">
        <x-event.moers-festival-panel class="mt-24"></x-event.moers-festival-panel>

        <div class="px-4 pt-4 mt-24 border-t border-gray-200 sm:px-0">
            <div class="text-sm max-w-prose">
                <p class="text-gray-400">
                    Veranstaltungen werden über den Veranstaltungskalender der Stadt Moers bezogen.
                    Um Veranstaltungen hinzuzufügen, trage sie bitte <a
                        href="https://www.moers.de/de/inhalt/veranstaltungsvorschlag/" target="_blank"
                        class="font-medium text-gray-500 hover:underline">hier</a> ein oder schreibe für weitere Wünsche
                    eine Mail an
                    <a href="mailto:moersapp@lambdadigamma.com"
                        class="text-gray-500 hover:underline">moersapp@lambdadigamma.com</a>.
                </p>
            </div>
        </div>

    </div>



    {{-- <div class="grid grid-cols-1 gap-6 md:grid-cols-2 md:pt-8">
        <x-card>
            <div class="px-4 py-3 bg-white border-b border-gray-200 sm:px-6">
                <h3 class="text-lg font-semibold leading-6 text-gray-900">
                    Heute
                </h3>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach ($todayEvents as $event)
                <x-event.row :event="$event"></x-event.row>
                @endforeach
            </div>
        </x-card>
        <x-card>
            <div class="divide-y divide-gray-200">
                @foreach ($nextUpcoming as $event)
                <x-event.row :event="$event"></x-event.row>
                @endforeach
            </div>
        </x-card>
    </div> --}}
</x-layout.main>