@props([
    'item' => null,
	'hasChildren' => null,
])

@php
	$hasChildren = $hasChildren ?? !empty($item?->children);
@endphp

<li
    {!! $attributes->merge([
        'class' => 'brave-nav-item' . ($hasChildren ? ' brave-nav-item-has-children' : ''),
    ]) !!}>
    {{ $slot }}
</li>
