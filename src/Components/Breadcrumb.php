<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;
use Log1x\Crumb\Facades\Crumb;

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
		$items = Crumb::build();

		if (! is_singular() || is_search() || ! $this->hasParentPage(get_the_ID())) {
			return $items;
		}

		$parentItems = $this->getParentItems(get_the_ID());

		if ($parentItems->isNotEmpty()) {
			$items->splice(1, 0, $parentItems->all());
			$items = $this->removeArchive($items, get_post_type());
		}

		return $items;
	}

	private function hasParentPage(int $postId): bool
	{
		return post_type_supports(get_post_type($postId), 'parent-page');
	}

	/**
	 * Add `parent-page` support items
	 */
	private function getParentItems(int $postId): Collection
	{
		$parentIds = $this->getParentPagesIds($postId);

		return collect(array_reverse($parentIds))
			->map(fn (int $id) => [
				'id' => $id,
				'label' => get_the_title($id),
				'url' => get_permalink($id),
			]);
	}

	private function getParentPagesIds(int $postId): array
	{
		if (! $this->hasParentPage($postId)) {
			return [];
		}

		$parentPageSlug = get_all_post_type_supports(get_post_type($postId))['parent-page'][0]['slug'] ?? null;
		$parent = $parentPageSlug ? get_page_by_path($parentPageSlug) : null;
		if (! $parent) {
			return [];
		}
		$ancestors = get_post_ancestors($parent->ID);

		return [$parent->ID, ...$ancestors];
	}

	/**
	 * Remove the CPT archive that Log1x/Crumb adds.
	 */
	private function removeArchive(Collection $items, string $cpt): Collection
	{
		$archiveUrl = get_post_type_archive_link($cpt);

		return $items
			->reject(fn ($item) => isset($item['url']) && $item['url'] === $archiveUrl)
			->values();
	}
}
