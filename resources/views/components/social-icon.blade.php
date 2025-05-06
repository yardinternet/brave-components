{{-- blade-formatter-disable --}}
<{{ $tag }}
	{{ $attributes->merge(array_filter([
	    'class' => 'social-icon ' . $class,
	    'href' => $shareLink,
	    'aria-label' => $ariaLabel,
	    'title' => $title,
	    'target' => $target,
	    'rel' => $rel,
	])) }}>
	<i class="{{ $icon }} fa-fw" aria-hidden="true"></i>
</{{ $tag }}>
