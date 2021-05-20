<x-layouts.main>
    <x-slot name="header">
        Straße {{ $street->name }}
    </x-slot>

    <div class="mt-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="overflow-hidden bg-white rounded-lg shadow-lg">
            <nav class="overflow-y-auto" style="max-height: 40rem;" aria-label="Directory">
                @foreach($street->pickupItems()->groupBy(fn($item) => $item['date']) as $key => $items)
                    <div class="relative">
                        <div class="z-10 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">
                            <h3>{{ \Carbon\Carbon::parse($key)->isoFormat('LL') }}</h3>
                        </div>
                        <ul class="relative z-0 divide-y divide-gray-200">

                            @foreach($items as $item)
                                <li class="bg-white">
                                    <div class="relative px-6 py-5 flex items-center space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                                        <div class="flex-shrink-0">
                                            @switch($item->type)
                                                @case('organic')
                                                <div class="h-10 w-10 rounded-full bg-green-500"></div>
                                                @break

                                                @case('paper')
                                                <div class="h-10 w-10 rounded-full bg-blue-500"></div>
                                                @break

                                                @case('residual')
                                                <div class="h-10 w-10 rounded-full bg-gray-500"></div>
                                                @break

                                                @case('plastic')
                                                <div class="h-10 w-10 rounded-full bg-yellow-500"></div>
                                                @break

                                            @endswitch
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <a href="#" class="focus:outline-none">
                                                <!-- Extend touch target to entire panel -->
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ __('rubbish-types.' . $item->type) }}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate">
                                                    {{ \Carbon\Carbon::parse($item->date)->isoFormat('LL') }}
                                                </p>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </nav>
        </div>
    </div>

</x-layouts.main>
