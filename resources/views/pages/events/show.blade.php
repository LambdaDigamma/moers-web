<x-layout.main>

    <div class="min-h-screen bg-gray-100">
        <x-regular-navigation-bar>
            <x-slot name="breadcrumbs">
                <x-breadcrumb-item href="{{ route('events.index') }}">
                    Veranstaltungen
                </x-breadcrumb-item>
                <x-breadcrumb-item current>
                    {{ $event->name }}
                </x-breadcrumb-item>
            </x-slot>
        </x-regular-navigation-bar>

        <main class="py-10">
            <!-- Page header -->
            {{-- <div
                class="max-w-3xl px-4 mx-auto sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-7xl lg:px-8">
                <div class="flex items-center space-x-5">
                    <div class="flex-shrink-0">
                        <div class="relative">
                            <img class="w-16 h-16 rounded-full"
                                src="https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80"
                                alt="">
                            <span class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Ricardo Cooper</h1>
                        <p class="text-sm font-medium text-gray-500">Applied for <a href="#" class="text-gray-900">Front
                                End
                                Developer</a> on <time datetime="2020-08-25">August 25, 2020</time></p>
                    </div>
                </div>
                <div
                    class="flex flex-col-reverse mt-6 space-y-4 space-y-reverse justify-stretch sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">
                    <button type="button"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                        Teilen
                    </button>
                    <button type="button"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                        Merken
                    </button>
                </div>
            </div> --}}

            <div
                class="grid max-w-3xl grid-cols-1 gap-6 mx-auto mt-8 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
                <div class="space-y-6 lg:col-start-1 lg:col-span-2">
                    <!-- Description list-->
                    <section aria-labelledby="applicant-information-title">
                        <div class="bg-white shadow sm:rounded-lg">
                            @if (false)
                            <?php
                            $image = "https://2020.moers-festival.de/fileadmin/user_upload/Ete_Large_Andre___Symann20200529_185442_SZ6_2156.jpg";
                            // $image = "https://2020.moers-festival.de/fileadmin/_processed_/6/1/csm_SaveTheDate_HP_20201105_4367f08a6a.jpg";
                            ?>
                            <img class="border-b border-gray-200 sm:rounded-t-lg" src="{{ $image }}" />
                            @endif
                            <div class="px-4 py-5 sm:px-6">
                                <h2 id="applicant-information-title"
                                    class="text-lg font-medium leading-6 text-gray-900">
                                    {{ $event->name }}
                                </h2>
                                {{-- <p class="max-w-2xl mt-1 text-sm text-gray-500">
                                    Personal details and application.
                                </p> --}}
                            </div>
                            @if ($event->cancelled_at)
                            <div class="border-t border-gray-200">
                                <div class="p-4 border-l-4 border-red-400 bg-red-50">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-red-700">
                                                Diese Veranstaltung wurde abgesagt.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Datum
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            @if ($event->start_date)
                                            <span>
                                                {{ $event->start_date->isoFormat('LLL') }}
                                            </span>
                                            @if ($event->end_date)
                                            <span> - </span>
                                            <span>
                                                {{ $event->end_date->isoFormat('LLL') }}
                                            </span>
                                            @endif
                                            @endif
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Kategorie
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            @if ($event->category)
                                            {{ $event->category ?? 'n/v' }}
                                            @else
                                            n/v
                                            @endif
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Veranstalter
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            @if ($event->extras)
                                            {{ $event->extras->get('organizer', 'n/v') }}
                                            @endif
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Ort
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            @if ($event->extras)
                                            {{ $event->extras->get('location', 'n/v') }}
                                            @endif
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Beschreibung
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {!! nl2br($event->description) !!}
                                        </dd>
                                    </div>
                                    {{-- <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Attachments
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            <ul class="border border-gray-200 divide-y divide-gray-200 rounded-md">
                                                <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                                    <div class="flex items-center flex-1 w-0">
                                                        <!-- Heroicon name: solid/paper-clip -->
                                                        <svg class="flex-shrink-0 w-5 h-5 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="flex-1 w-0 ml-2 truncate">
                                                            resume_front_end_developer.pdf
                                                        </span>
                                                    </div>
                                                    <div class="flex-shrink-0 ml-4">
                                                        <a href="#"
                                                            class="font-medium text-blue-600 hover:text-blue-500">
                                                            Download
                                                        </a>
                                                    </div>
                                                </li>

                                                <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                                    <div class="flex items-center flex-1 w-0">
                                                        <!-- Heroicon name: solid/paper-clip -->
                                                        <svg class="flex-shrink-0 w-5 h-5 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="flex-1 w-0 ml-2 truncate">
                                                            coverletter_front_end_developer.pdf
                                                        </span>
                                                    </div>
                                                    <div class="flex-shrink-0 ml-4">
                                                        <a href="#"
                                                            class="font-medium text-blue-600 hover:text-blue-500">
                                                            Download
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </dd>
                                    </div> --}}
                                </dl>
                            </div>
                            <div>
                                <a href="{{ $event->ics() }}" download="{{$event->name}}.ics"
                                    class="block px-4 py-4 text-sm font-medium text-center text-gray-500 bg-gray-50 hover:text-gray-700 sm:rounded-b-lg">Kalendereintrag
                                    laden</a>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="lg:col-start-3 lg:col-span-1">

                    <section aria-labelledby="organizer-title">
                        <div class="px-4 py-5 bg-white shadow sm:rounded-lg sm:px-6">
                            <h2 id="organizer-title" class="text-lg font-medium text-gray-900 sr-only">Veranstalter</h2>
                            <h3 id="organizer-title" class="text-lg font-medium text-gray-900">
                                @if ($event->extras)
                                {{ $event->extras->get('organizer', 'n/v') }}
                                @endif
                            </h3>

                            <div class="mt-2 text-sm line-clamp-3">
                                Auch gibt es niemanden, der den Schmerz an sich liebt, sucht oder wünscht, nur, weil er
                                Schmerz ist, es sei denn, es
                                kommt zu zufälligen Umständen, in denen Mühen und Schmerz ihm große Freude bereiten
                                können. Um ein triviales Beispiel zu
                                nehmen, wer von uns unterzieht sich je anstrengender körperlicher Betätigung, außer um
                                Vorteile daraus zu ziehen?
                            </div>

                            <div class="flex flex-col mt-6 justify-stretch">
                                <button type="button"
                                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Mehr Informationen
                                </button>
                            </div>
                        </div>
                    </section>

                    <section aria-labelledby="location-title" class="mt-6">
                        <div class="px-4 py-5 bg-white shadow sm:rounded-lg sm:px-6">
                            <h2 id="location-title" class="text-lg font-medium text-gray-900">Veranstaltungsort</h2>

                            <div class="mt-2">
                                <adress class="text-sm leading-none text-gray-900">
                                    @if ($event->extras && $event->extras->get('location'))
                                    {{ $event->extras->get('location') }}<br>
                                    @endif
                                    @if ($event->extras && $event->extras->get('street'))
                                    {{ $event->extras->get('street') }}<br>
                                    @endif
                                    @if ($event->extras && $event->extras->get('postcode'))
                                    {{ $event->extras->get('postcode') . " " . $event->extras->get('place') }}
                                    @endif
                                </adress>

                            </div>

                            <div class="mt-6 bg-gray-100 rounded-lg h-44">

                            </div>
                            <div class="flex flex-col mt-6 justify-stretch">
                                <button type="button"
                                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Navigation starten
                                </button>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>

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
    <x-footer></x-footer>

</x-layout.main>