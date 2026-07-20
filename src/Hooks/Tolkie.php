<?php

namespace Yard\Brave\Hooks;

use Yard\Hook\Action;
use Yard\Hook\Filter;

class Tolkie
{
	#[Action('wp_footer')]
	public function addTolkieScript(): void
	{
		wp_print_script_tag([
			'class' => 'tolkieIntegrationScript',
			'id' => 'tolkie-script',
			'type' => 'module',
			'src' => 'https://app.tolkie.nl/',
			'crossorigin' => 'anonymous',
			'data-tolkie-token' => config('tolkie.token'),
			'data-tolkie-state' => 'separateButtons',
			'defer' => '',
		]);
	}

	#[Filter('render_block_core/heading')]
	#[Filter('render_block_core/post-title')]
	public function addTolkieMarker(string $content, array $block): string
	{
		$content .= '<div class="yard-blocks-tolkie | tolkie-buttons-afterbegin"></div>';
		return $content;
	}
}
