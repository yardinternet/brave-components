<?php

namespace Yard\Brave\Components\Breadcrumb;

use Illuminate\Support\Collection;

class Crumb
{
    /**
     * The breadcrumb configuration.
     */
    protected $config = [];

    /**
     * The breadcrumb items.
     */
    protected Collection $breadcrumb;

   /**
    * Initialize the Crumb instance.
    */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->breadcrumb = collect();
    }

    /**
     * Add an item to the breadcrumb collection.
     */
    protected function add(string $key, ?string $value = null, ?int $id = null, bool $blog = false): self
    {
        if (
            $blog === true &&
            get_option('show_on_front') === 'page' &&
            ! empty($blogId = get_option('page_for_posts')) &&
            ! empty($this->config['blog'])
        ) {
            $this->add(
                $this->config['blog'],
                get_permalink((int)$blogId),
                (int)$blogId
            );
        }

        $this->breadcrumb->push([
            'id' => $id,
            'label' => $key,
            'url' => $value,
        ]);

        return $this;
    }

    /**
     * Build the breadcrumb collection.
     */
    public function build(): Collection
    {
        if (is_front_page()) {
            return $this->breadcrumb;
        }

        $this->add(
            $this->config['home'],
            home_url()
        );

        if (
            is_home() &&
            ! empty($this->config['blog'])
        ) {
            $this->add(
                $this->config['blog']
            );
            return $this->breadcrumb;
        }

        if (is_page()) {
            $ancestors = collect(
                get_ancestors(get_the_ID(), 'page')
            )->reverse();

            if ($ancestors->isNotEmpty()) {
                $ancestors->each(function ($item) {
                    $this->add(
                        get_the_title($item),
                        get_permalink((int)$item),
                        (int)$item
                    );
                });
            }

            $this->add(
                get_the_title(),
                null,
                get_the_ID()
            );
            return $this->breadcrumb;
        }

        if (is_category()) {
            $category = single_cat_title('', false);

            $this->add(
                $category,
                null,
                get_cat_ID($category),
                true
            );
            return $this->breadcrumb;
        }

        if (is_tag()) {
            $tag = single_tag_title('', false);
            $term = get_term_by('name', $tag, 'post_tag');
            $termId = $term ? $term->term_id : null;

            $this->add(
                $tag,
                null,
                $termId,
                true
            );
            return $this->breadcrumb;
        }

        if (is_date()) {
            if (is_month()) {
                $this->add(
                    get_the_date('F Y'),
                    null,
                    null,
                    true
                );
                return $this->breadcrumb;
            }

            if (is_year()) {
                $this->add(
                    get_the_date('Y'),
                    null,
                    null,
                    true
                );
                return $this->breadcrumb;
            }

            $this->add(
                get_the_date(),
                null,
                null,
                true
            );
            return $this->breadcrumb;
        }

        if (is_tax()) {
            $term = single_term_title('', false);
            $termObj = get_term_by('name', $term, get_query_var('taxonomy'));
            $termId = $termObj ? $termObj->term_id : null;

            $this->add(
                $term,
                null,
                $termId
            );
            return $this->breadcrumb;
        }

        if (is_search()) {
            $this->add(
                sprintf($this->config['search'], get_search_query())
            );
            return $this->breadcrumb;
        }

        if (is_author()) {
            $this->add(
                sprintf($this->config['author'], get_the_author()),
                null,
                (int)get_the_author_meta('ID'),
                true
            );
            return $this->breadcrumb;
        }

        if (is_post_type_archive()) {
			$this->add(
                post_type_archive_title('', false)
            );
            return $this->breadcrumb;
        }

        if (is_404()) {
            $this->add(
                $this->config['not_found']
            );
            return $this->breadcrumb;
        }

        if (is_singular('post')) {
            $categories = get_the_category(get_the_ID());

            if (! empty($categories)) {
                foreach ($categories as $index => $category) {
                    $this->add(
                        $category->name,
                        get_category_link($category),
                        $category->term_id,
                        $index === 0
                    );
                }

                $this->add(
                    get_the_title(),
                    null,
                    get_the_ID()
                );
                return $this->breadcrumb;
            }

            $this->add(
                get_the_title(),
                null,
                get_the_ID(),
                true
            );
            return $this->breadcrumb;
        }

        $type = get_post_type_object(
            get_post_type()
        );

        if (! empty($type)) {
			$parentItems = $this->getParentItems(get_the_ID());

			if ($parentItems->isNotEmpty()) {
				$parentItems->map(function ($item) {
					$this->add(
						$item['label'],
						$item['url'],
						$item['id']
					);
				});
			}
        }

        $this->add(
            get_the_title(),
            null,
            get_the_ID()
        );
        return $this->breadcrumb;
    }

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

		private function hasParentPage(int $postId): bool
	{
		return post_type_supports(get_post_type($postId), 'parent-page');
	}
}
