<img
	class="{{ $class }}"
	src="{{ $src }}"
	alt="{{ $alt }}"
	{{ !empty($fetchPriority) ? 'fetchpriority="' . $fetchPriority . '" ' : ''  }}
	loading="{{ $loading }}"
	style="{{ $focalPoint }}">
