<div @class([
	'wp-block-buttons',
	$align,
	$className,
	$attributes->get('class'),
])>
	<div class="wp-block-button is-style-back">
		<a class="wp-block-button__link" href="{{ $link }}">{!! $text !!}</a>
	</div>
</div>
