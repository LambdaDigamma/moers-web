<x-layouts.main>
    <x-slot name="header">
        Kraftstoff
    </x-slot>

    <div class="mt-24 max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto">

        <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
{{--            @for ($i = 0; $i < 10; $i++)--}}

            <li class="col-span-1">
                <x-petrol.petrol-station-card
                    name="Kuster Energy"
                    brand="Kuster Energy"
                    :isOpen="true"
                ></x-petrol.petrol-station-card>
            </li>

            <li class="col-span-1">
                <x-petrol.petrol-station-card
                    name="Jet Moers Klever Str. 61"
                    brand="JET"
                    :isOpen="false"
                ></x-petrol.petrol-station-card>
            </li>

{{--            @endfor--}}



        </ul>

    </div>
</x-layouts.main>
