<x-layouts.main>
    <div class="min-h-screen bg-gray-200">
        <x-top-navigation></x-top-navigation>
        <div class="max-w-6xl min-h-screen pb-24 mx-auto bg-gray-100 shadow-md">
            <div class="relative" style="height: 50vh;">
                {{-- <x-scaffold.navigation class="absolute top-0 left-0 right-0 z-10"></x-scaffold.navigation> --}}
                <div class="absolute top-0 bottom-0 left-0 right-0 bg-black" aria-hidden="true">
                    {{-- <img class="object-cover object-right-bottom w-full h-full" src="/images/moers.jpg"
                        style="filter: brightness(30%); -webkit-filter: brightness(30%);"> --}}
                </div>
                <div class="absolute z-20 flex flex-col items-center justify-center w-full h-full">
                    <h1 class="text-2xl font-bold text-center text-white lg:text-3xl">
                        Digitale Bürgerinformation <br /> auf Basis von <span class="">offenen Daten</span>
                    </h1>
                </div>
            </div>
            <div class="relative max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
                <!--
                																<SearchPanel class="-mt-24"></SearchPanel>-->
                <x-home.categories-panel class="-mt-24"></x-home.categories-panel>
            </div>

            <div class="max-w-6xl px-4 mx-auto mt-12 space-y-2 lg:mt-32 sm:px-6 lg:px-8">
                <div class="flex flex-row items-baseline justify-between">
                    <h2 class="text-lg font-bold text-gray-800 lg:text-2xl">Nächste Veranstaltungen</h2>
                    <inertia-link class="text-sm font-semibold text-red-500 lg:text-lg">Mehr</inertia-link>
                </div>
            </div>

            <div class="flex pb-6 mt-4 overflow-x-scroll no-scrollbar">
                <div class="flex px-4 space-x-4 flex-nowrap sm:px-6 lg:px-8">

                    @foreach($events as $event)
                    <div class="relative inline-block w-80 group">
                        <div
                            class="overflow-hidden transition-shadow duration-300 ease-in-out bg-gray-300 rounded shadow-md aspect-w-6 aspect-h-4 hover:shadow-xl">

                        </div>
                        <div
                            class="relative mx-2 -mt-10 transition duration-150 ease-in-out bg-white rounded-lg shadow-lg group-hover:bg-gray-100">
                            <div class="px-4 py-4">
                                <div class="flex items-baseline">
                                    <div class="text-xs font-semibold tracking-wide text-gray-400 uppercase">
                                        {{ $event->extras['location'] }}
                                    </div>
                                </div>
                                <h4 class="mt-1 text-base font-semibold leading-tight text-gray-900">
                                    {{ $event->name }}
                                </h4>
                                <div class="mt-0">
                                    <span class="text-xs font-medium text-gray-700 md:text-sm leading-0">
                                        So, 9. Juni 2020 11:00
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
        <Footer></Footer>
    </div>
</x-layouts.main>