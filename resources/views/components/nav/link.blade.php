@props([
	'item' => null,
	'href' => null,
	'isActive' => false,
	'activeClass' => null,
	'hasChildren' => null,
])

@php
	$hasChildren = $hasChildren ?? !empty($item?->children);
	$href = $item?->url ?? $href;
	$label = !$slot->isEmpty() ? $slot : ($item?->label ?? '');

	$pointsToCurrentPage = $isActive || ($item?->active ?? false);
	$isInActiveSection = $pointsToCurrentPage || ($item?->activeParent ?? false);

	// A parent and child can share a URL ("Nieuws" inside "Actueel"); only the child claims aria-current="page".
	$childPointsToCurrentPage = (bool) array_filter($item?->children ?? [], fn ($child) => $child->active ?? false);

	$ariaCurrent = match (true) {
		$pointsToCurrentPage && !$childPointsToCurrentPage => 'page',
		$hasChildren && $isInActiveSection => 'true',
		default => null,
	};

	$attributes = $attributes
		->class([
			'brave-nav-link',
			'brave-nav-link-has-children' => $hasChildren,
			'brave-nav-link-is-active' => $isInActiveSection,
			$activeClass => $isInActiveSection && $activeClass,
			$item?->classes ?? null,
		])
		->merge(['aria-current' => $ariaCurrent]);
@endphp

@if ($hasChildren)
	<button {{ $attributes->merge(['type' => 'button']) }}>
		{{ $label }}
	</button>
@else
	<a {{ $attributes->merge(['href' => $href]) }}>
		{{ $label }}
	</a>
@endif
