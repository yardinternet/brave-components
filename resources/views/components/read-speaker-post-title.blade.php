@php
	/**
	 * @var callable $showReadSpeaker
	 * @var callable $showReadSpeakerAfter
	 * @var callable $showReadSpeakerBefore
	 * @var string $title
	 */
@endphp

@if ($showReadSpeaker() && $showReadSpeakerBefore())
	<x-brave-read-speaker />
@endif
<h1 {{ $attributes->merge(['class' => 'brave-read-speaker-post-title']) }}>{!! $title !!}</h1>
@if ($showReadSpeaker() && $showReadSpeakerAfter())
	<x-brave-read-speaker />
@endif
