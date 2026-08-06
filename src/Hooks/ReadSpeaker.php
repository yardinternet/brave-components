<?php

declare(strict_types=1);

namespace Yard\Brave\Hooks;

use Illuminate\Support\Facades\Blade;
use Yard\Brave\Components\ReadSpeaker as ReadSpeakerComponent;
use Yard\Hook\Action;
use Yard\Hook\Filter;

class ReadSpeaker
{
	public const POSITION_BEFORE = 'before';
	public const POSITION_AFTER = 'after';

	private int $customerId;
	private string $disable;
	private bool $automaticallyAddToH1;
	private string $h1Position;

	public function __construct()
	{
		// use old config names as fallback for backwards-compatibility
		$this->customerId = (int) (config('components.read_speaker.customer_id') ?? config('components.readSpeaker.customerId', 0));
		$this->disable = config('components.read_speaker.disable', config('components.readSpeaker.disable', ''));
		$this->automaticallyAddToH1 = (bool) config('components.read_speaker.automatically_add_to_h1', config('components.readSpeaker.automaticallyAddToH1', true));
		$this->h1Position = self::POSITION_BEFORE === config('components.read_speaker.h1_position')
			? self::POSITION_BEFORE
			: self::POSITION_AFTER;
	}

	/**
	 * Add the ReadSpeaker script to the footer of the site if a valid customer ID is set.
	 */
	#[Action('wp_footer')]
	public function addReadSpeakerScript(): void
	{
		$baseUrl = 'https://cdn-eu.readspeaker.com/script/' . $this->customerId . '/webReader/webReader.js';

		$src = add_query_arg(
			[
				'pids' => 'wr',
				'disable' => $this->disable,
			],
			$baseUrl
		);

		wp_print_inline_script_tag('', [
			'id' => 'readspeaker-script',
			'src' => $src,
		]);
	}

	/**
	 * Add the ReadSpeaker button partial to H1's, either before or after the
	 * heading depending on the h1_position config value.
	 */
	#[Filter('render_block_core/heading')]
	#[Filter('render_block_core/post-title')]
	public function addReadSpeakerButtonToH1(string $blockContent, array $block): string
	{
		if (! $this->automaticallyAddToH1) {
			return $blockContent;
		}

		if (isset($block['attrs']['level']) && (int) $block['attrs']['level'] === 1) {
			$button = Blade::renderComponent(new ReadSpeakerComponent());

			return self::POSITION_BEFORE === $this->h1Position
				? $button . $blockContent
				: $blockContent . $button;
		}

		return $blockContent;
	}
}
