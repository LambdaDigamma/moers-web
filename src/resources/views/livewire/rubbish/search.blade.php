<div>
    <div class="overflow-hidden bg-white rounded-lg shadow-md">
        <div class="flex flex-1 h-16 px-4 border-b border-gray-200">
            <form action="#" class="flex w-full md:ml-0" method="GET">
                <label class="sr-only" for="search_field">Search</label>
                <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                        <x-heroicon-s-search class="w-5 h-5" />
                    </div>
                    <input id="search_field"
                        class="block w-full h-full py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 border-transparent focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent sm:text-sm"
                        name="search" wire:model.live="search" placeholder="Suche eine Straße..." type="search">
                </div>
            </form>
        </div>
        <nav class="overflow-y-auto" style="max-height: 20rem;" aria-label="Directory">
            <div class="relative">
                <ul class="relative z-0 divide-y divide-gray-200">
                    @foreach($streets as $street)
                    <x-rubbish.street-row :street="$street"></x-rubbish.street-row>
                    @endforeach
                </ul>
            </div>
        </nav>
    </div>
</div>