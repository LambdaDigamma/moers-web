<x-layout.main>

    <div class="min-h-screen bg-gray-100">
        <x-regular-navigation-bar>
            <x-slot name="breadcrumbs">
                <x-breadcrumb-item href="{{ route('news.index') }}">
                    Neuigkeiten
                </x-breadcrumb-item>
            </x-slot>
        </x-regular-navigation-bar>

{{--        <div class="aspect-h-9 aspect-w-16 bg-gray-200 w-full">--}}

{{--        </div>--}}
        <main class="py-10">


            <div class="max-w-3xl gap-6 mx-auto mt-8 sm:px-6 lg:max-w-7xl grid-cols-3 grid">
                @foreach ($posts as $post)
                <div class="col-span-1 bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="aspect-w-16 aspect-h-9 w-full relative">
                        <?php $header = $post->getFirstMedia('header') ?>
                        @if ($header)
                            {{ $header->img()->attributes(['class' => 'object-cover object-top w-full h-full']) }}
                        @else

                        @endif
{{--                        <div class="absolute top-0 right-0 mt-2 mr-2 flex items-start justify-end">--}}
{{--                            <span>External</span>--}}
{{--                        </div>--}}
                    </div>
                    <div class="px-4 py-3">
                        <h3 class="font-medium truncate">
                            <a href="{{ $post->external_href ?? '#' }}" target="_blank" rel="noopener">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="text-gray-500 truncate text-sm">
                            {{ $post->published_at->toFormattedDateString() }} • {{ $post->source ?? '' }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>

    {!! $posts->links() !!}
{{--    <x-footer></x-footer>--}}

</x-layout.main>
