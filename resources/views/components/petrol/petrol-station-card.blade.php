<div {{ $attributes->merge(['class' => 'relative flex flex-col text-center bg-white rounded-lg shadow divide-y divide-gray-200']) }}>
    <div class="absolute top-0 right-0 -mt-3 mr-4">
        @if ($isOpen)
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-600 text-white shadow-md">
                geöffnet
            </span>
        @else
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-600 text-white shadow-md">
                geschlossen
            </span>
        @endif
    </div>
    <div class="flex-1 flex flex-col p-6">
        {{--                        <img class="w-32 h-32 flex-shrink-0 mx-auto bg-black rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=60" alt="">--}}
        <h3 class="text-gray-900 text-sm font-medium text-left">{{ $name }}</h3>
        <dl class="mt-1 flex-grow flex flex-col justify-between">
            <dt class="sr-only">Brand</dt>
            <dd class="text-gray-500 text-sm text-left">{{ $brand }}</dd>
            {{--                            <dt class="sr-only">Role</dt>--}}
            {{--                            <dd class="mt-3">--}}
            {{--                                <span class="px-2 py-1 text-green-800 text-xs font-medium bg-green-100 rounded-full">Admin</span>--}}
            {{--                            </dd>--}}
        </dl>
    </div>
{{--    <div>--}}
{{--        <div class="-mt-px flex divide-x divide-gray-200">--}}
{{--            <div class="w-0 flex-1 flex">--}}
{{--                <a href="#" class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">--}}
{{--                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">--}}
{{--                        <path fill-rule="evenodd" d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z" clip-rule="evenodd"></path>--}}
{{--                    </svg>--}}
{{--                    <span class="ml-3">Route</span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
