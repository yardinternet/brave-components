<?php

declare(strict_types=1);

namespace Yard\Brave\Hooks;

use Yard\Hook\Action;
use Yard\Hook\Filter;

class Tolkie
{
	#[Action('wp_footer')]
	public function addTolkieScript(): void
	{
		wp_print_script_tag([
			...config('components.tolkie.html_attributes'),
			'class' => 'tolkieIntegrationScript',
			'id' => 'tolkie-script',
			'type' => 'module',
			'src' => 'https://app.tolkie.nl/',
			'crossorigin' => 'anonymous',
			'defer' => '',
			'data-tolkie-token' => config('components.tolkie.token'),
		]);
	}

	#[Filter('render_block_core/heading')]
	#[Filter('render_block_core/post-title')]
	public function addTolkieTag(string $content, array $block): string
	{
		if (!config('components.tolkie.automatically_add_to_h1', true))
			return $content;

		$content .= '<div class="tolkie-buttons-afterbegin"></div>';
		return $content;
	}
}
