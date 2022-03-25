@props(['show_more' => true])

<div {{ $attributes->merge(['class' => '']) }}>
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-green-700 rounded-lg shadow-xl lg:grid lg:grid-cols-2 lg:gap-4">
            <div class="px-6 pt-10 pb-12 sm:pt-16 sm:px-16 lg:py-16 lg:pr-0 xl:py-20 xl:px-20">
                <div class="lg:self-center">
                    <h2 class="text-2xl font-extrabold text-white sm:text-4xl">
                        <span class="block">Du vergisst auch manchmal den Müll?</span>
                        <span class="block">Mein Moers hilft Dir!</span>
                    </h2>
                    <p class="mt-4 leading-6 text-green-200 md:text-lg">
                        Die App Mein Moers sendet Dir für Deine Straße am Tag vor der Leerung eine
                        Erinnerung, den
                        richtigen Müll an die Straße zu bringen.
                    </p>
                    @if ($show_more)
                    <a href="{{ route('marketing.app') }}"
                        class="inline-flex items-center px-5 py-3 mt-8 text-base font-medium text-green-600 bg-white border border-transparent rounded-md shadow hover:bg-green-50">
                        Mehr erfahren
                    </a>
                    @endif
                </div>
            </div>
            <div class="-mt-6 aspect-w-5 aspect-h-3 md:aspect-w-2 md:aspect-h-1">
                <img class="object-cover object-left-top transform translate-x-6 translate-y-6 rounded-md sm:translate-x-16 lg:translate-y-20"
                    src="/images/marketing/rubbish-app.png" alt="App screenshot">
            </div>
        </div>
    </div>
</div>