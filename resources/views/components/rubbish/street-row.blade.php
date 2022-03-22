<li class="bg-white">
    <div
        class="relative flex items-center px-4 py-5 space-x-3 md:px-6 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
        {{-- <div class="flex-shrink-0">--}}
            {{-- <img class="w-10 h-10 rounded-full"
                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixqx=ThAiHdGqH9&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                alt="">--}}
            {{-- </div>--}}
        <div class="flex-1 min-w-0">
            <a href="{{ route('rubbish.show', $street_id) }}" class="focus:outline-none">
                <!-- Extend touch target to entire panel -->
                <span class="absolute inset-0" aria-hidden="true"></span>
                <p class="text-sm font-medium text-gray-900">
                    {{ $title }}
                </p>
                <p class="text-sm text-gray-500 truncate">
                    {{ $subtitle }}
                </p>
            </a>
        </div>
    </div>
</li>