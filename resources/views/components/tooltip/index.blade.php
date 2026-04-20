@props(['id', 'arrowClass' => ''])

<div
    {{ $attributes->merge([
        'id' => $id,
        'role' => 'tooltip',
        'aria-hidden' => 'true',
        'class' => 'js-brave-tooltip',
    ]) }}>
    {{ $slot }}
    <div @class(['js-brave-tooltip-arrow', $arrowClass])></div>
</div>
