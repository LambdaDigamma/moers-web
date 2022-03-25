<button {{ $attributes->merge([
    'class' => 'relative flex items-center gap-6 mx-auto overflow-hidden bg-white shadow-sm ring-1 ring-black/5
    rounded-xl'
    ]) }}>
    <div class="absolute w-20 h-20 overflow-hidden rounded-full shadow-md -left-6">
        <img class="absolute z-0 object-cover w-full h-full" src="{{ $image }}" aria-hidden="true">
        {{-- <div class="absolute inset-0 bg-blue-400 mix-blend-multiply"></div> --}}
    </div>
    <div class="flex flex-col py-3 pr-4 pl-[4.5rem]">
        <strong class="text-sm font-medium text-slate-900">{{ $text }}</strong>
        {{-- <span class="text-sm font-medium text-slate-500">Technical advisor</span> --}}
    </div>
</button>