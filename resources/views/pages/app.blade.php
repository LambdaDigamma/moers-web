<x-layout.main>
    <main class="min-h-screen bg-gray-100">
        <x-top-navigation></x-top-navigation>


        <x-marketing.rubbish-cta class="pt-12"></x-marketing.rubbish-cta>
        <div class="mt-12 bg-black">
            <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 md:py-16 lg:px-8 lg:py-20">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    <span class="block text-white">Überzeugt?</span>
                    <span class="block text-yellow-400">Hier gibts die App!</span>
                </h2>
                <div class="flex mt-8 space-x-4">
                    <x-app-store href="https://apps.apple.com/de/app/mein-moers/id1305862555"></x-app-store>
                    {{-- <x-play-store href=""></x-play-store> --}}
                </div>
            </div>
        </div>
    </main>
</x-layout.main>