@props([
	'mode' => 'click',
])

<ul
    {!! $attributes->merge([
        'class' => 'brave-nav-dropdown brave-nav-dropdown-on-' . $mode,
        'data-mode' => $mode,
    ]) !!}>
    {{ $slot }}
</ul>
