@props(['ariaLabel'])

<nav
    {{ $attributes->merge([
        'aria-label' => $ariaLabel,
        'class' => 'brave-nav',
    ]) }}>
    {{ $slot }}
</nav>
