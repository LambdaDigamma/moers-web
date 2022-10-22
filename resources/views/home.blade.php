<x-layout.main>
    <x-regular-navigation-bar></x-regular-navigation-bar>
    <div class="min-h-screen pb-24">
        <div
            class="grid max-w-3xl grid-cols-1 gap-6 mx-auto mt-8 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
            <div class="space-y-6 lg:col-start-1 lg:col-span-2">
                <!-- Description list-->
                 <section aria-labelledby="applicant-information-title">
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h2 id="applicant-information-title" class="text-lg font-medium leading-6 text-gray-900">
                                Neues aus Moers
                            </h2>
                        </div>
                        <div class="border-t border-b border-gray-200">
                            <ul class="divide-gray-200 divide-y">
                                @foreach($news as $item)
                                <li class="">
                                    <a
                                        href="{{ $item->external_href ?? "#" }}"
                                        target="_blank"
                                        rel="noopener nofollow"
                                        class="w-full flex flex-row items-center space-x-4 px-4 py-2 hover:bg-gray-100"
                                    >
                                        <div class="w-12 h-12 rounded-md bg-gray-100 flex-shrink-0 overflow-hidden">
                                                <?php $media = $item->getFirstMedia('header') ?>
                                            @if($media)
                                                {{ $media->img()->attributes(['class' => 'object-cover object-top w-full h-full']) }}
                                            @endif
                                        </div>
                                        <div class="flex-grow">
                                            <h4 class="font-medium truncate w-full">
                                                {{ $item->title }}
                                            </h4>
                                            <p class="text-gray-500 text-sm">
                                                {{ $item->published_at->diffForHumans() }} • {{ $item->source }}
                                            </p>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <a href="{{ route('news.index') }}"
                                class="block px-4 py-4 text-sm font-medium text-center text-gray-500 bg-gray-50 hover:text-gray-700 sm:rounded-b-lg">
                                Alle Neuigkeiten anzeigen
                            </a>
                        </div>
                    </div>
                </section>

                <!-- Comments-->
                {{-- <section aria-labelledby="notes-title">
                    <div class="bg-white shadow sm:rounded-lg sm:overflow-hidden">
                        <div class="divide-y divide-gray-200">
                            <div class="px-4 py-5 sm:px-6">
                                <h2 id="notes-title" class="text-lg font-medium text-gray-900">Notes</h2>
                            </div>
                            <div class="px-4 py-6 sm:px-6">
                                <ul role="list" class="space-y-8">
                                    <li>
                                        <div class="flex space-x-3">
                                            <div class="flex-shrink-0">
                                                <img class="w-10 h-10 rounded-full"
                                                    src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                    alt="">
                                            </div>
                                            <div>
                                                <div class="text-sm">
                                                    <a href="#" class="font-medium text-gray-900">Leslie Alexander</a>
                                                </div>
                                                <div class="mt-1 text-sm text-gray-700">
                                                    <p>Ducimus quas delectus ad maxime totam doloribus reiciendis ex.
                                                        Tempore
                                                        dolorem maiores. Similique voluptatibus tempore non ut.</p>
                                                </div>
                                                <div class="mt-2 space-x-2 text-sm">
                                                    <span class="font-medium text-gray-500">4d ago</span>
                                                    <span class="font-medium text-gray-500">&middot;</span>
                                                    <button type="button"
                                                        class="font-medium text-gray-900">Reply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="flex space-x-3">
                                            <div class="flex-shrink-0">
                                                <img class="w-10 h-10 rounded-full"
                                                    src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                    alt="">
                                            </div>
                                            <div>
                                                <div class="text-sm">
                                                    <a href="#" class="font-medium text-gray-900">Michael Foster</a>
                                                </div>
                                                <div class="mt-1 text-sm text-gray-700">
                                                    <p>Et ut autem. Voluptatem eum dolores sint necessitatibus quos.
                                                        Quis eum
                                                        qui dolorem accusantium voluptas voluptatem ipsum. Quo facere
                                                        iusto quia
                                                        accusamus veniam id explicabo et aut.</p>
                                                </div>
                                                <div class="mt-2 space-x-2 text-sm">
                                                    <span class="font-medium text-gray-500">4d ago</span>
                                                    <span class="font-medium text-gray-500">&middot;</span>
                                                    <button type="button"
                                                        class="font-medium text-gray-900">Reply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="flex space-x-3">
                                            <div class="flex-shrink-0">
                                                <img class="w-10 h-10 rounded-full"
                                                    src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                    alt="">
                                            </div>
                                            <div>
                                                <div class="text-sm">
                                                    <a href="#" class="font-medium text-gray-900">Dries Vincent</a>
                                                </div>
                                                <div class="mt-1 text-sm text-gray-700">
                                                    <p>Expedita consequatur sit ea voluptas quo ipsam recusandae. Ab
                                                        sint et
                                                        voluptatem repudiandae voluptatem et eveniet. Nihil quas
                                                        consequatur
                                                        autem. Perferendis rerum et.</p>
                                                </div>
                                                <div class="mt-2 space-x-2 text-sm">
                                                    <span class="font-medium text-gray-500">4d ago</span>
                                                    <span class="font-medium text-gray-500">&middot;</span>
                                                    <button type="button"
                                                        class="font-medium text-gray-900">Reply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="px-4 py-6 bg-gray-50 sm:px-6">
                            <div class="flex space-x-3">
                                <div class="flex-shrink-0">
                                    <img class="w-10 h-10 rounded-full"
                                        src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80"
                                        alt="">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <form action="#">
                                        <div>
                                            <label for="comment" class="sr-only">About</label>
                                            <textarea id="comment" name="comment" rows="3"
                                                class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                placeholder="Add a note"></textarea>
                                        </div>
                                        <div class="flex items-center justify-between mt-3">
                                            <a href="#"
                                                class="inline-flex items-start space-x-2 text-sm text-gray-500 group hover:text-gray-900">
                                                <!-- Heroicon name: solid/question-mark-circle -->
                                                <svg class="flex-shrink-0 w-5 h-5 text-gray-400 group-hover:text-gray-500"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span>
                                                    Some HTML is okay.
                                                </span>
                                            </a>
                                            <button type="submit"
                                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Comment
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> --}}
            </div>

            <section aria-labelledby="timeline-title" class="lg:col-start-3 lg:col-span-1">
                <x-card>
                    <div class="px-4 py-4 sm:px-4">
                        <h2 id="timeline-title" class="text-lg font-semibold text-gray-900">
                            Heutige Veranstaltungen
                        </h2>
                    </div>
                    <div class="border-t border-b border-gray-200">
                        <ul role="list" class="divide-y divide-y-300">
                            @foreach ($events as $event)
                            <li>
                                <x-event.row :event="$event"></x-event.row>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="flex flex-col px-4 pb-4 mt-4 justify-stretch sm:px-4">
                        <button type="button"
                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-gray-900 border border-transparent rounded-md shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
                            Alle ansehen
                        </button>
                    </div>
                </x-card>
            </section>

            <section aria-labelledby="parking-title" class="lg:col-start-3 lg:col-span-1">
                <x-dashboard.parking-overview :parkingAreas="$parkingAreas">

                </x-dashboard.parking-overview>
            </section>
        </div>

    </div>
</x-layout.main>
