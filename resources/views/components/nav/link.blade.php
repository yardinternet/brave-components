@props([
    'item' => null,
    'href' => null,
    'active' => false,
])

@php
    if ($item && $href) {
        throw new InvalidArgumentException(
            'BraveNavLink: Do not pass both a Navi $item and $href.'
        );
    }

    if (!$item && !$href) {
        throw new InvalidArgumentException(
            'BraveNavLink: Either a Navi $item or $href must be provided.'
        );
    }

	$hasChildren = !empty($item?->children);

    $href = $hasChildren
        ? '#'
        : ($item->url ?? $href);

    $active = $active
    || ($item->active ?? false)
    || ($item->activeParent ?? false);
@endphp

<a {{ $attributes
    ->class([
        'brave-nav-link',
        'is-active' => $active,
        $item->classes ?? null,
    ])
    ->merge([
        'href' => $href,
        'aria-current' => $active ? 'page' : null,
    ])
}}>
    {{ $slot ?? $item->label ?? '' }}
</a>
