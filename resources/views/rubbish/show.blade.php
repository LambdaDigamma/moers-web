<x-layout.main>

    <div class="min-h-screen bg-gray-100">
        <x-regular-navigation-bar>
            <x-slot name="breadcrumbs">
                <x-breadcrumb-item href="{{ route('rubbish.index') }}">
                    Abfallkalender
                </x-breadcrumb-item>
                <x-breadcrumb-item current>
                    {{ $street->name }}
                </x-breadcrumb-item>
            </x-slot>
        </x-regular-navigation-bar>

        <main class="py-10">
            <div class="px-4 mx-auto sm:px-6 lg:px-8 max-w-7xl">
                <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                    <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                        <div class="flex flex-wrap items-center justify-between -mt-4 -ml-4 sm:flex-nowrap">
                            <div class="mt-4 ml-4">
                                <div class="flex items-center">
                                    {{-- <div class="flex-shrink-0">
                                        <img class="w-12 h-12 rounded-full"
                                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixqx=ThAiHdGqH9&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                            alt="">
                                    </div> --}}
                                    <div>
                                        <h2 class="text-lg font-medium leading-6 text-gray-900">
                                            {{ $street->name }}
                                        </h2>
                                        <p class="text-sm text-gray-500">
                                            {{ $street->street_addition }}
                                            {{-- <a href="#">
                                                @tom_cook
                                            </a> --}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-shrink-0 mt-4 ml-4">
                                <a href="https://cms.sbm-moers.de/abfk/ical/{{ now()->year }}-{{ $street->id }}.ics"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <x-heroicon-s-calendar class="w-5 h-5 mr-2 -ml-1 text-gray-400" />
                                    <span>
                                        Kalender (ics)
                                    </span>
                                </a>
                                <a href="https://cms.sbm-moers.de/abfk/abfallkalender_moers.php?h=0&streetid={{ $street->id }}&rw=0&newjear={{ now()->year }}"
                                    download="abfallkalender.pdf" rel="noopener" target="_blank"
                                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <x-heroicon-s-download class="w-5 h-5 mr-2 -ml-1 text-gray-400" />
                                    <span>
                                        PDF <span class="sr-only">herunterladen</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-hidden bg-white">
                        <nav class="overflow-y-auto" style="max-height: 40rem;" aria-label="Directory">
                            @foreach($street->pickupItems()->groupBy(fn($item) => $item['date']) as $key => $items)
                            <div class="relative">
                                <div
                                    class="sticky top-0 z-10 px-6 py-1 text-sm font-medium text-gray-500 border-t border-b border-gray-200 bg-gray-50">
                                    <h3>{{ \Carbon\Carbon::parse($key)->isoFormat('LL') }}</h3>
                                </div>
                                <ul class="relative z-0 divide-y divide-gray-200">

                                    @foreach($items as $item)
                                    <li class="bg-white">
                                        <div class="relative flex items-center px-6 py-5 space-x-3">
                                            <div class="flex-shrink-0">
                                                @switch($item->type)
                                                @case('organic')
                                                <div
                                                    class="inline-flex items-center justify-center w-10 h-10 bg-green-500 rounded-full">
                                                    <x-hero-icon name="abfall-outline" class="w-5 h-5 text-white" />
                                                </div>
                                                @break

                                                @case('paper')
                                                <div
                                                    class="inline-flex items-center justify-center w-10 h-10 bg-blue-500 rounded-full">
                                                    <x-hero-icon name="abfall-outline" class="w-5 h-5 text-white" />
                                                </div>
                                                @break

                                                @case('residual')
                                                <div
                                                    class="inline-flex items-center justify-center w-10 h-10 bg-gray-500 rounded-full">
                                                    <x-hero-icon name="abfall-outline" class="w-5 h-5 text-white" />
                                                </div>
                                                @break

                                                @case('plastic')
                                                <div
                                                    class="inline-flex items-center justify-center w-10 h-10 bg-yellow-500 rounded-full">
                                                    <x-hero-icon name="abfall-outline" class="w-5 h-5 text-white" />
                                                </div>
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
            </div>
            <x-marketing.rubbish-cta class="py-16"></x-marketing.rubbish-cta>
            {{-- <div class="">
                <div class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-green-700 rounded-lg shadow-xl lg:grid lg:grid-cols-2 lg:gap-4">
                        <div class="px-6 pt-10 pb-12 sm:pt-16 sm:px-16 lg:py-16 lg:pr-0 xl:py-20 xl:px-20">
                            <div class="lg:self-center">
                                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                                    <span class="block">Du vergisst auch manchmal den Müll?</span>
                                    <span class="block">Mein Moers hilft Dir!</span>
                                </h2>
                                <p class="mt-4 text-lg leading-6 text-green-200">
                                    Die App Mein Moers sendet Dir für Deine Straße am Tag vor der Leerung eine
                                    Erinnerung, den
                                    richtigen Müll an die Straße zu bringen.
                                </p>
                                <a href="#"
                                    class="inline-flex items-center px-5 py-3 mt-8 text-base font-medium text-green-600 bg-white border border-transparent rounded-md shadow hover:bg-green-50">Mehr
                                    erfahren</a>
                            </div>
                        </div>
                        <div class="-mt-6 aspect-w-5 aspect-h-3 md:aspect-w-2 md:aspect-h-1">
                            <img class="object-cover object-left-top transform translate-x-6 translate-y-6 rounded-md sm:translate-x-16 lg:translate-y-20"
                                src="/images/marketing/rubbish-app.png" alt="App screenshot">
                        </div>
                    </div>
                </div>
            </div> --}}
        </main>

        {{-- <div class="min-h-screen bg-gray-200">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-4 gap-6">
                    <div class="col-span-3 py-10 bg-white">

                    </div>
                    <div class="col-span-1 py-10 bg-white">

                    </div>
                </div>
            </div>
            <div class="max-w-6xl min-h-screen pb-24 mx-auto bg-gray-100 shadow-md">
                <h2>
                    {{ $event->name }}
                </h2>
                <p>
                    {{ $event->description }}
                </p>
                <p>{{ $event->start_date }}</p>
                <p>{{ $event->organisation ?? 'keine Organisation' }}</p>
                <p>abgesagt</p>
                <p>Ort</p>

            </div>
        </div> --}}

        <!--
      This example requires Tailwind CSS v2.0+ 
      
      This example requires some changes to your config:
      
      ```
      // tailwind.config.js
      module.exports = {
        // ...
        plugins: [
          // ...
          require('@tailwindcss/aspect-ratio'),
        ]
      }
      ```
    -->
        <x-footer>
        </x-footer>
</x-layout.main>

{{-- <x-layouts.main>
    <x-slot name="header">
        Straße {{ $street->name }}
    </x-slot>

    <div class="px-4 mx-auto mt-16 sm:px-6 lg:px-8 max-w-7xl">
        <div class="overflow-hidden bg-white rounded-lg shadow-lg">
            <nav class="overflow-y-auto" style="max-height: 40rem;" aria-label="Directory">
                @foreach($street->pickupItems()->groupBy(fn($item) => $item['date']) as $key => $items)
                <div class="relative">
                    <div
                        class="sticky top-0 z-10 px-6 py-1 text-sm font-medium text-gray-500 border-t border-b border-gray-200 bg-gray-50">
                        <h3>{{ \Carbon\Carbon::parse($key)->isoFormat('LL') }}</h3>
                    </div>
                    <ul class="relative z-0 divide-y divide-gray-200">

                        @foreach($items as $item)
                        <li class="bg-white">
                            <div
                                class="relative flex items-center px-6 py-5 space-x-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                                <div class="flex-shrink-0">
                                    @switch($item->type)
                                    @case('organic')
                                    <div class="w-10 h-10 bg-green-500 rounded-full"></div>
                                    @break

                                    @case('paper')
                                    <div class="w-10 h-10 bg-blue-500 rounded-full"></div>
                                    @break

                                    @case('residual')
                                    <div class="w-10 h-10 bg-gray-500 rounded-full"></div>
                                    @break

                                    @case('plastic')
                                    <div class="w-10 h-10 bg-yellow-500 rounded-full"></div>
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

</x-layouts.main> --}}