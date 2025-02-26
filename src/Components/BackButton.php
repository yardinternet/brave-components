<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use WP_Post;

class BackButton extends Component
{
	public string $link = 'javascript:history.back();';
	public string $text = 'Terug';
	public string $align = 'alignwide';
	public string $className;

	public function __construct(
		string $link = '',
		string $text = '',
		string $align = '',
		string $className = ''
	) {
		global $post;

		if ('' !== $link) {
			$this->link = $link;
		} elseif (is_a($post, 'WP_Post')) {
			$this->initializeLinkAndText($post);
		}

		if ('' !== $text) {
			$this->text = $text;
		}

		if ('' !== $align) {
			$this->align = $align;
		}

		$this->className = $className;
	}

	private function initializeLinkAndText(WP_Post $post): void
	{
		$parentID = wp_get_post_parent_id($post->ID);

		if (0 !== $parentID) {
			$this->setLinkToParent($parentID);
		} else {
			$this->setLinkToPostTypeParent($post);
		}
	}

	private function setLinkToParent(int $parentID): void
	{
		$parent = get_post($parentID);
		$this->link = get_permalink($parent);
		$this->text = sprintf('Terug naar %s', strtolower(get_the_title($parent)));
	}

	private function setLinkToPostTypeParent(WP_Post $post): void
	{
		$parentPageSlug = get_all_post_type_supports(get_post_type($post->ID))['parent-page'][0]['slug'] ?? '';
		if ('' !== $parentPageSlug) {
			$this->link = home_url($parentPageSlug);
			$this->text = 'Terug naar overzicht';
		}
	}

	public function render(): View|Closure|string
	{
		return view('brave::components.back-button');
	}
}
