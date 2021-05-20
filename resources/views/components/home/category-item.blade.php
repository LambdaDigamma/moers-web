<div {{ $attributes->merge(['class' => 'relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-gray-500 ' . $cornerClass ]) }}>
    <div>
        {{ $icon }}
    </div>
    <div class="mt-8">
        <h3 class="text-lg font-medium">
            <a class="focus:outline-none" href="{{ $href }}">
                <!-- Extend touch target to entire panel -->
                <span aria-hidden="true" class="absolute inset-0"></span>
                {{ $title }}
            </a>
        </h3>
    </div>
    <span aria-hidden="true" class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400">
        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"/>
        </svg>
    </span>
</div>
