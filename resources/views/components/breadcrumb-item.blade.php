<li>
    <div class="flex items-center">
        <svg class="flex-shrink-0 w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20" aria-hidden="true">
            <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
        </svg>
        <a href="{{ $href }}" aria-current="{{ $current ? 'page' : null }}"
            class="ml-4 text-sm font-medium text-gray-500 truncate hover:text-gray-700"
            style="max-width: 20ch">{{ $slot }}</a>
    </div>
</li>