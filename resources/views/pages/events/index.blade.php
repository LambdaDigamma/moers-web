<x-layout.main>
    <x-regular-navigation-bar>
        <x-slot name="breadcrumbs">
            <x-breadcrumb-item href="{{ route('events.index') }}">
                Veranstaltungen
            </x-breadcrumb-item>
        </x-slot>
    </x-regular-navigation-bar>
    <x-container>

        <livewire:events-exploration />

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
    </x-container>
</x-layout.main>