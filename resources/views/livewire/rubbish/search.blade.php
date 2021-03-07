<div>

    <div class="overflow-hidden bg-white rounded-lg shadow-lg">
        <div class="flex-1 flex h-16 px-4 border-b border-gray-200">
            <form action="#" class="w-full flex md:ml-0" method="GET">
                <label class="sr-only" for="search_field">Search</label>
                <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                        <!-- Heroicon name: solid/search -->
                        <svg aria-hidden="true" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" fill-rule="evenodd"/>
                        </svg>
                    </div>
                    <input
                        id="search_field"
                        class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent sm:text-sm"
                        name="search"
                        wire:model="search"
                        placeholder="Suche eine Straße..."
                        type="search"
                    >
                </div>
            </form>
        </div>
        <nav class="overflow-y-auto" style="max-height: 20rem;" aria-label="Directory">
            <div class="relative">

{{--                <div class="z-10 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-6 py-1 text-sm font-medium text-gray-500">--}}
{{--                    <h3>A</h3>--}}
{{--                </div>--}}
                <ul class="relative z-0 divide-y divide-gray-200">
                    @foreach($streets as $street)
                        <x-rubbish.street-row :street="$street"></x-rubbish.street-row>
                    @endforeach
                </ul>
            </div>
        </nav>
    </div>

{{--    <input type="search" wire:model="search" placeholder="Straße suchen..." />--}}

{{--    <div>--}}
{{--        <ul>--}}
{{--            @foreach($streets as $street)--}}
{{--                <li class="flex flex-row">--}}
{{--                    {{ $street->name }}--}}
{{--                </li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}
{{--    </div>--}}



{{--    {{ $search }}--}}

</div>
