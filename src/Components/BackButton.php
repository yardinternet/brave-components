<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\Component;
use Illuminate\View\View;
use WP_Post;
use Yard\Brave\Components\Traits\ParentPage;

class BackButton extends Component
{
	use ParentPage;
	public string $link = 'javascript:history.back();';
	public string $text = 'Terug';
	public string $align = '';
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

		if (is_int($parentID) && 0 !== $parentID) {
			$this->setLinkToParent($parentID);
		} else {
			$this->setLinkToPostTypeParent($post);
		}
	}

	private function setLinkToParent(int $parentID): void
	{
		$parent = get_post($parentID);
		$this->link = $parent ? get_permalink($parent) : 'javascript:history.back();';
		$this->text = $parent ? sprintf('Terug naar %s', strtolower(get_the_title($parent))) : $this->text;
	}

	private function setLinkToPostTypeParent(WP_Post $post): void
	{
		$parentPageSlug = $this->getParentPageSlug($post->ID);

		if (null !== $parentPageSlug) {
			$this->link = home_url($parentPageSlug);
			$this->text = 'Terug naar overzicht';
		}
	}

	public function render(): Factory|View
	{
		return view('brave::components.back-button');
	}
}
