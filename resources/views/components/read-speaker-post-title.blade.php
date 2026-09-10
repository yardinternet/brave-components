@php
	/**
	 * @var string $title
	 */

	use Yard\Brave\Support\ReadSpeaker;
@endphp

@if (ReadSpeaker::isEnabled() && ReadSpeaker::showBefore())
	<x-brave-read-speaker/>
@endif
<h1 {{ $attributes->merge(['class' => 'brave-read-speaker-post-title']) }}>{!! $title !!}</h1>
@if (ReadSpeaker::isEnabled() && ReadSpeaker::showAfter())
	<x-brave-read-speaker/>
@endif
