@props(['regular' => true, 'fluidmobile' => false])

<div class="@if($regular) mx-auto max-w-7xl @if (!$fluidmobile) px-4 @endif sm:px-6 lg:px-8 @endif">
    {{ $slot }}
</div>