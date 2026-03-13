@props([
    'item' => null,
    'href' => null,
    'isActive' => false,
	'activeClass' => null,
	'hasChildren' => null,
])

@php
	$hasChildren = $hasChildren ?? !empty($item?->children);

    $href = $item->url ?? $href;
    $label = $slot ?? $item->label ?? '';

    $isActive = $isActive
    || ($item->active ?? false)
    || ($item->activeParent ?? false);

    $baseAttributes = $attributes
        ->class([
            'brave-nav-link',
			'brave-nav-link-has-children' => $hasChildren,
            'brave-nav-link-is-active' => $isActive,
            $activeClass => $isActive && $activeClass,
            $item->classes ?? null,
        ])
        ->merge([
            'aria-current' => $isActive ? 'page' : null,
        ]);
@endphp

@if ($hasChildren)
    <button {{ $baseAttributes }}>
        {{ $label }}
    </button>
@else
    <a {{ $baseAttributes->merge(['href' => $href]) }}>
        {{ $label }}
    </a>
@endif
