@props(['id', 'ariaLabel', 'useShow' => false])

<dialog
    {{ $attributes->merge([
        'id' => $id,
        'aria-label' => $ariaLabel,
        'class' => 'js-brave-dialog',
		'data-use-show' => $useShow,
    ]) }}>
    {{ $slot }}
</dialog>
