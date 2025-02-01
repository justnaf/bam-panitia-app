@props(['active','title'])

@php
$classes = ($active ?? false)
? 'font-extrabold px-2 py-2 bg-emerald-500 w-full text-start rounded-md mb-2'
: 'px-2 py-2 hover:bg-emerald-500 w-full text-start rounded-md mb-2';
@endphp
<div x-data="{ show: false }" class="relative">
    <button @click="show = !show" {{ $attributes->merge(['class' => $classes]) }}>
        <span class="me-2">{{ $title }}</span> <i class="fas fa-chevron-up transform transition-transform duration-500 ease-in-out" :class="show ? 'rotate-180' : 'rotate-0'"></i>
    </button>
    <div x-show="show" class="w-full rounded-md mt-2 ps-3 transition-all duration-500 ease-in-out" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
        {{ $slot }}
    </div>
</div>
