<x-layout.main>
    <x-regular-navigation-bar>
        <x-slot name="breadcrumbs">
            <x-breadcrumb-item href="{{ route('parking-area.index') }}" current>
                Abfallkalender
            </x-breadcrumb-item>
        </x-slot>
    </x-regular-navigation-bar>

    <div class="px-4 pt-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <livewire:rubbish.search />
    </div>

</x-layout.main>