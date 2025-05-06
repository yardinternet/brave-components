<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SocialIcon extends Component
{
	public function __construct(
		public ?string $ariaLabel = null,
		public ?string $class = null,
		public ?string $icon = null,
		public ?string $permalink = null,
		public ?string $rel = null,
		public ?string $shareLink = null,
		public string $tag = 'a',
		public ?string $target = null,
		public ?string $title = null,
		public ?string $type = null,
	) {
		$this->setTypeDefaults();
		$this->setGeneralDefaults();
	}

	private function setTypeDefaults(): void
	{
		$this->permalink ??= get_the_permalink() ?: '';

		if ('x-twitter' === $this->type) {
			$this->icon ??= 'fa-brands fa-x-twitter';
			$this->shareLink ??= 'https://twitter.com/intent/tweet?url=' . urlencode($this->permalink);
			$this->title ??= 'Deel op X (Twitter)';
		} elseif ('facebook' === $this->type) {
			$this->icon ??= 'fa-brands fa-facebook-f';
			$this->shareLink ??= 'https://facebook.com/sharer/sharer.php?u=' . urlencode($this->permalink);
			$this->title ??= 'Deel op Facebook';
		} elseif ('linkedin' === $this->type) {
			$this->icon ??= 'fa-brands fa-linkedin-in';
			$this->shareLink ??= 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode($this->permalink);
			$this->title ??= 'Deel op LinkedIn';
		} elseif ('whatsapp' === $this->type) {
			$this->icon ??= 'fa-brands fa-whatsapp';
			$this->shareLink ??= 'https://wa.me/?text=' . urlencode($this->permalink);
			$this->title ??= 'Deel op Whatsapp';
		} elseif ('mail' === $this->type) {
			$this->icon ??= 'fa-light fa-envelope';
			$this->shareLink ??= 'mailto:?body=' . urlencode($this->permalink);
			$this->title ??= 'Mail';
		} elseif ('web-share-api' === $this->type) {
			$this->class = 'js-web-share-api ' . $this->class;
			$this->icon ??= 'fa-light fa-share-nodes';
			$this->rel ??= '';
			$this->tag = 'button';
			$this->target ??= '';
			$this->title ??= 'Delen';
		}
	}

	private function setGeneralDefaults(): void
	{
		$this->ariaLabel ??= $this->title;
		$this->rel ??= 'noopener';
		$this->target ??= '_blank';
	}

	public function shouldRender(): bool
	{
		return ! empty($this->title) && ! empty($this->icon);
	}

	public function render(): View
	{
		return view('brave::components.social-icon');
	}
}
