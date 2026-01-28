@props(['id', 'ariaLabel'])

<dialog
    {{ $attributes->merge([
        'id' => $id, // Props because they are required
        'aria-label' => $ariaLabel,
        'class' => 'js-brave-dialog ' . $attributes->get('class'),
    ]) }}>
    {{ $slot }}
</dialog>
