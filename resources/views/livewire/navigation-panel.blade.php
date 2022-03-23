<div class="p-4">
    <h2 class="text-base font-medium text-gray-900">
        Welche Navigation möchtest Du öffnen?
    </h2>

    <div class="grid grid-cols-1 mt-4 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
        <a href="{{ $googleMapsHref }}" target="_blank"
            class="relative flex flex-col items-center justify-center p-4 bg-white border rounded-lg shadow-sm cursor-pointer focus:outline-none hover:bg-gray-50">
            <img src="/img/google-maps.png" class="w-20 h-20" aria-hidden="true" />
            <p class="font-medium text-gray-900">
                Google Maps
            </p>
        </a>
        <a href="{{ $appleMapsHref }}" target="_blank"
            class="relative flex flex-col items-center justify-center p-4 bg-white border rounded-lg shadow-sm cursor-pointer focus:outline-none hover:bg-gray-50">
            <img src="/img/apple-maps.png" class="w-20 h-20" aria-hidden="true" />
            <p class="font-medium text-gray-900">
                Apple Maps
            </p>
        </a>
    </div>