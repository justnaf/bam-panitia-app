@props(['active'])

@php
$classes = ($active ?? false)
? 'flex px-2 py-2 bg-emerald-500 w-full text-start rounded-md mb-2'
: 'flex px-2 py-2 hover:bg-emerald-500 w-full text-start rounded-md mb-2';
@endphp
<a {{ $attributes->merge(['class' => $classes]) }}>
    {{$slot}}
</a>
