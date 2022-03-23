<div {{ $attributes->merge(['class' => 'divide-y divide-gray-100']) }}>
    @foreach ($items as $item)
    <div class="flex flex-row justify-between py-2">
        <dt class="text-sm font-medium text-gray-500 truncate">{{ $item['description'] }}</dt>
        <dd class="text-sm font-medium text-gray-900">{{ $item['time'] }}</dd>
    </div>
    @endforeach
</div>