<div class="bg-black">
    <div class="flex items-center justify-between h-10 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex space-x-4">
            <a href="{{ route('rubbish.index') }}" class="p-1 rounded hover:bg-gray-800">
                <x-hero-icon name="abfall-outline" class="w-5 h-5 text-white" />
                <span class="sr-only">Abfallkalender</span>
            </a>
            <a href="{{ route('events.index') }}" class="p-1 rounded hover:bg-gray-800">
                <x-hero-icon name="calendar-outline" class="w-5 h-5 text-white" />
                <span class="sr-only">Veranstaltungen</span>
            </a>
            <a href="{{ route('parking-area.index') }}" class="p-1 rounded hover:bg-gray-800">
                <x-hero-icon name="parking-outline" class="w-5 h-5 text-white" />
                <span class="sr-only">Parkplätze</span>
            </a>
        </div>

        {{-- <div class="flex items-center space-x-6">
            <a href="#" class="text-sm font-medium text-white hover:text-gray-100">Sign in</a>
            <a href="#" class="text-sm font-medium text-white hover:text-gray-100">Create an account</a>
        </div> --}}
    </div>
</div>