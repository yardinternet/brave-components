<?php

declare(strict_types=1);

namespace Yard\Brave\Hooks;

use Illuminate\Support\Facades\Blade;
use Yard\Brave\Components\ReadSpeaker as ReadSpeakerComponent;
use Yard\Hook\Action;
use Yard\Hook\Filter;

class ReadSpeaker
{
	private int $customerId;
	private string $disable;
	private bool $automaticallyAddToH1;

	public function __construct()
	{
		$this->customerId = (int) config('components.readSpeaker.customerId', 0);
		$this->disable = config('components.readSpeaker.disable', '');
		// use 'automaticallyAddToH1' as fallback for backwards-compatibility
		$this->automaticallyAddToH1 = (bool) config('components.readSpeaker.automatically_add_to_h1', config('components.readSpeaker.automaticallyAddToH1', true));

		dd($this->automaticallyAddToH1);
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
	 * Add the ReadSpeaker button partial to H1's
	 */
	#[Filter('render_block_core/heading')]
	#[Filter('render_block_core/post-title')]
	public function addReadSpeakerButtonToH1(string $blockContent, array $block): string
	{
		if (! $this->automaticallyAddToH1) {
			return $blockContent;
		}

		if (isset($block['attrs']['level']) && (int) $block['attrs']['level'] === 1) {
			return $blockContent . Blade::renderComponent(new ReadSpeakerComponent());
		}

		return $blockContent;
	}
}
