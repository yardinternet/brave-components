@props(['id', 'ariaLabel', 'useShow' => false])

<dialog
    {{ $attributes->merge([
        'id' => $id,
        'aria-label' => $ariaLabel,
        'class' => 'js-brave-dialog ' . $attributes->get('class'),
		'data-use-show' => $useShow,
    ]) }}>
    {{ $slot }}
</dialog>
