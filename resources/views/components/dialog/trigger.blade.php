@props(['dialogId'])

<button
    {{ $attributes->merge([
        'data-dialog-id' => $dialogId,
        'type' => 'button',
        'class' => 'js-brave-dialog-trigger',
    ]) }}>
    {{ $slot }}
</button>
