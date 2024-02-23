<div>
    @if ($state == 'open')
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-green-100 text-green-800">
        Geöffnet
    </span>
    @elseif($state == 'closed')
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-red-100 text-red-800">
        Geschlossen
    </span>
    @else
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-gray-100 text-gray-800">
        Unbekannt
    </span>
    @endif
</div>