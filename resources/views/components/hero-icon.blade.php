@props(['name'])

@if ($name == 'calendar-outline')
<svg {{ $attributes->merge([ 'class' => '']) }} fill="none" stroke="currentColor" viewBox="0 0 24 24"
    xmlns="http://www.w3.org/2000/svg">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
    </path>
</svg>
@elseif ($name == 'abfall-outline')
<svg {{ $attributes->merge([ 'class' => '']) }} clip-rule="evenodd" fill-rule="evenodd" stroke-linecap="round"
    stroke-linejoin="round" stroke-miterlimit="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <g fill="none" stroke="currentColor">
        <path d="m19 2h-15l1.056 20h12.23z" stroke-width="2.69" transform="matrix(.583333 0 0 .875 5.91667 1.75)" />
        <g stroke-width="2">
            <circle cx="8" cy="20.5" r="1" stroke-linejoin="bevel" />
            <path d="m8.25 5-2.25-1h12l-1 1z" transform="translate(0 -.5)" />
        </g>
    </g>
</svg>
@elseif ($name == 'parking-outline')
<svg {{ $attributes->merge([ 'class' => '']) }} xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd"
    stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="1.5" clip-rule="evenodd" viewBox="0 0 24 24">
    <path fill="none" stroke="currentColor" stroke-width="2"
        d="M8 3.5v17M8 3.5h5.75C16.097 3.5 18 5.403 18 7.75c0 0 0 0 0 0 0 2.347-1.903 4.25-4.25 4.25H8" />
</svg>
{{-- @elseif ($name == 'trash-outline')
<svg {{ $attributes->merge([ 'class' => '']) }} fill="none" stroke="currentColor" viewBox="0 0 24 24"
xmlns="http://www.w3.org/2000/svg">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
</path>
</svg> --}}
@endif