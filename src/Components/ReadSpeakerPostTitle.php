<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use Illuminate\View\Component;
use Illuminate\View\Factory;
use Illuminate\View\View;
use Yard\Brave\Hooks\ReadSpeaker as ReadSpeakerHook;

class ReadSpeakerPostTitle extends Component
{
	public function __construct(
		public string $title = '',
	) {
		$this->title = $this->resolveTitle($title);
	}

	public function render(): View|Factory|string
	{
		return view('brave::components.read-speaker-post-title');
	}

	public function showReadSpeaker(): bool
	{
		return 0 !== (int) (config('components.read_speaker.customer_id') ?? config('components.readSpeaker.customerId', 0));
	}

	public function showReadSpeakerBefore(): bool
	{
		return ReadSpeakerHook::POSITION_BEFORE === config('components.read_speaker.h1_position');
	}

	public function showReadSpeakerAfter(): bool
	{
		return ! $this->showReadSpeakerBefore();
	}

	private function resolveTitle(string $title): string
	{
		if (blank($title)) {
			$title = get_the_title();
		}

		if (blank($title)) {
			$title = 'Onbekende titel';
		}

		return wp_kses_post($title);
	}
}
