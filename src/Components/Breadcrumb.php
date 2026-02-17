<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;
use Yard\Brave\Components\Breadcrumb\Crumb;

class Breadcrumb extends Component
{
	public function __construct(
		public ?string $listClass = '',
		public ?string $itemClass = '',
		public ?string $linkClass = '',
		public ?string $currentItemClass = '',
		public ?Collection $items = null,
	) {
		$this->items = $this->items->isNotEmpty() ? $this->items : $this->items();
	}

	public function render(): Factory|View
	{
		return view('brave::components.breadcrumb', [
			'items' => $this->items,
		]);
	}

	private function items(): Collection
	{
		$crumb = new Crumb(config('components.breadcrumb.labels'));

		return $crumb->build();
	}
}
