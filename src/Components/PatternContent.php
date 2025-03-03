<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\Component;
use Illuminate\View\View;

class PatternContent extends Component
{
	public string $patternContent = '';

	public function __construct(public string $slug = '')
	{
		$this->patternContent = $this->getPatternContent();
	}

	public function getPatternContent(): string
	{
		$pattern = new \WP_Query([
			'post_type' => 'wp_block',
			'post_status' => ['publish', 'draft'],
			'name' => $this->slug,
		]);

		if (! $pattern->have_posts()) {
			return '';
		}

		$post = $pattern->posts[0];

		if ($post instanceof \WP_Post) {
			return apply_filters('the_content', $post->post_content);
		}

		return '';
	}

	public function render(): View|Factory|string
	{
		if (empty($this->patternContent)) {
			return '';
		}

		return view('brave::components.pattern-content');
	}
}
