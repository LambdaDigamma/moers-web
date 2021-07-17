<x-layout.main>

    <div class="min-h-screen bg-gray-100">
        <x-regular-navigation-bar>
            <x-slot name="breadcrumbs">
                <x-breadcrumb-item href="{{ route('news.index') }}">
                    Neuigkeiten
                </x-breadcrumb-item>
            </x-slot>
        </x-regular-navigation-bar>

        <main class="py-10">
            <div class="max-w-3xl gap-6 mx-auto mt-8 sm:px-6 lg:max-w-7xl">
                @foreach ($posts as $post)
                <div>
                    <h3 class="text-lg font-semibold">
                        {{ $post->title }}
                    </h3>
                    <p class="text-gray-500">
                        {{ $post->published_at }}
                    </p>
                </div>
                @endforeach
            </div>
        </main>
    </div>
    <x-footer></x-footer>

</x-layout.main>