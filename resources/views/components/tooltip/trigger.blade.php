@props(['id', 'ariaDescribedby'])

<button
    {{ $attributes->merge([
        'id' => $id,
        'type' => 'button',
        'class' => 'js-brave-tooltip-trigger',
        'aria-describedby' => $ariaDescribedby,
    ]) }}>
    {{ $slot }}
</button>
