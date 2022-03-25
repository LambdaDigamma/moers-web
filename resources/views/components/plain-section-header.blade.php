<div {{ $attributes->merge(['class' => 'pb-3 border-b border-gray-200 sm:flex sm:items-center sm:justify-between']) }}>
    <h1 class="text-lg font-bold leading-6 text-gray-900 md:text-xl">
        {{ $slot }}
    </h1>
</div>