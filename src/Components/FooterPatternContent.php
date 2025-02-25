<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\Component;
use Illuminate\View\View;

class FooterPatternContent extends Component
{
	public string $footerPatternContent = '';

	/**
	 * Create a new component instance.
	 */
	public function __construct()
	{
		$this->footerPatternContent = $this->getPatternContent();
	}

	public function getPatternContent(): string
	{
		$footerPattern = new \WP_Query([
			'post_type' => 'wp_block',
			'name' => 'footer',
			'post_status' => 'draft',
		]);

		if (! $footerPattern->have_posts()) {
			return '';
		}

		$post = $footerPattern->posts[0];

		return apply_filters('the_content', $post->post_content);
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View|Factory|string
	{
		if(empty($this->footerPatternContent)) {
			return '';
		}

		return view('brave::components.footer-pattern-content');
	}
}
