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
            <section class="px-4 mx-auto sm:px-6 lg:px-8 max-w-7xl">
                <div class="flex flex-row justify-between">
                    <h1 class="text-xl font-bold text-gray-900">
                        Freie Parkplätze in Moers
                    </h1>
                </div>
                <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($parkingAreas as $parkingArea)
                    <x-parking.panel :parkingArea="$parkingArea"></x-parking.panel>
                    @endforeach
                </div>
            </section>
        </main>
</x-layout.main>