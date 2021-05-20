<x-layout.main>
    <div class="min-h-screen bg-gray-200">
        <div class="max-w-6xl min-h-screen pb-24 mx-auto bg-gray-100 shadow-md">
            <div class="relative h-80 lg:h-96">
                {{-- <x-navigation class="absolute top-0 left-0 right-0 z-10"></x-navigation> --}}
                <div class="absolute top-0 bottom-0 left-0 right-0 bg-gray-800" aria-hidden="true">
                    <img class="object-cover object-right-bottom w-full h-full" src="/images/moers.jpg"
                        style="filter: brightness(30%); -webkit-filter: brightness(30%);">
                </div>
            </div>
            <div class="relative max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
                <!--																<SearchPanel class="-mt-24"></SearchPanel>-->
                <x-category-panel class="-mt-24"></x-category-panel>
            </div>

            <div class="max-w-6xl px-4 mx-auto mt-12 space-y-2 lg:mt-32 sm:px-6 lg:px-8">
                <div class="flex flex-row items-baseline justify-between">
                    <h2 class="text-lg font-bold text-gray-800 lg:text-2xl">Nächste Veranstaltungen</h2>
                    <a class="text-sm font-semibold text-red-500 lg:text-lg">Mehr</a>
                </div>
            </div>

            <div class="flex pb-6 mt-4 overflow-x-scroll no-scrollbar">
                <div class="flex px-4 space-x-4 flex-nowrap sm:px-6 lg:px-8">

                    @foreach ($events as $event)

                    <a href="{{ route('events.show', [$event]) }}"
                        class="relative block w-64 w-full max-w-xs lg:w-104 group">
                        <div
                            class="overflow-hidden transition-shadow duration-300 ease-in-out bg-gray-300 rounded shadow-md aspect-w-6 aspect-h-4 hover:shadow-xl">

                        </div>
                        <div
                            class="relative mx-2 -mt-10 transition duration-150 ease-in-out bg-white rounded-lg shadow-lg group-hover:bg-gray-100">
                            <div class="px-4 py-4">
                                <div class="flex items-baseline">
                                    <div class="text-xs font-semibold tracking-wide uppercase text-true-gray-500">
                                        ENNI Eventhalle
                                    </div>
                                </div>
                                <h4 class="mt-0 text-base font-semibold text-gray-900">
                                    {{ $event->name }}
                                </h4>
                                <div class="mt-0">
                                    <span class="text-xs font-medium text-gray-700 md:text-sm leading-0">
                                        So, 9. Juni 2020 11:00
                                    </span>
                                </div>
                            </div>

                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            <!--								<div class="overflow-hidden bg-white rounded-lg shadow">-->
            <!--												<div class="px-4 py-5 sm:p-6">-->
            <!--																<div class="h-32"></div>-->
            <!--												</div>-->
            <!--								</div>-->
        </div>
        {{-- <Footer></Footer> --}}
    </div>
</x-layout.main>