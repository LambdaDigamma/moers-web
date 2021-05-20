<x-layouts.main>
    <div class="min-h-screen bg-gray-200">
        <div class="pb-24 mx-auto max-w-6xl min-h-screen bg-gray-100 shadow-md">
            <div class="relative" style="height: 50vh;">
                <x-scaffold.navigation class="absolute top-0 right-0 left-0 z-10"></x-scaffold.navigation>
                <div class="absolute top-0 right-0 bottom-0 left-0 bg-gray-800" aria-hidden="true">
                    <img class="object-cover object-right-bottom w-full h-full" src="/images/moers.jpg" style="filter: brightness(30%); -webkit-filter: brightness(30%);">
                </div>
                <div class="flex absolute z-20 flex-col justify-center items-center w-full h-full">
                    <h1 class="text-2xl lg:text-3xl font-bold text-center text-white">Digitale Bürgerinformation <br/> auf Basis von <span class="">offenen Daten</span></h1>
                </div>
            </div>
            <div class="relative px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">
                <!--
                																<SearchPanel class="-mt-24"></SearchPanel>-->
                <x-home.categories-panel class="-mt-24"></x-home.categories-panel>
            </div>

            <div class="px-4 mx-auto mt-12 space-y-2 max-w-6xl lg:mt-32 sm:px-6 lg:px-8">
                <div class="flex flex-row justify-between items-baseline">
                    <h2 class="text-lg font-bold text-gray-800 lg:text-2xl">Nächste Veranstaltungen</h2>
                    <inertia-link class="text-sm font-semibold text-red-500 lg:text-lg">Mehr</inertia-link>
                </div>
            </div>

            <div
                class="flex overflow-x-scroll pb-6 mt-4 no-scrollbar"
            >
                <div
                    class="flex flex-nowrap px-4 space-x-4 sm:px-6 lg:px-8"
                >

                    @foreach($events as $event)
                    <div class="inline-block relative w-80 group">
                        <div
                            class="overflow-hidden bg-gray-300 rounded shadow-md transition-shadow duration-300 ease-in-out aspect-w-6 aspect-h-4 hover:shadow-xl"
                        >

                        </div>
                        <div class="relative mx-2 -mt-10 bg-white rounded-lg shadow-lg transition duration-150 ease-in-out group-hover:bg-gray-100">
                            <div class="py-4 px-4">
                                <div class="flex items-baseline">
                                    <div class="text-xs font-semibold tracking-wide text-gray-400 uppercase">
                                        {{ $event->extras['location'] }}
                                    </div>
                                </div>
                                <h4 class="mt-1 text-base font-semibold text-gray-900 leading-tight">
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
