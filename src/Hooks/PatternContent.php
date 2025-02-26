<?php

declare(strict_types=1);

namespace Yard\Brave\Hooks;

use WP_Post;
use Yard\Hook\Action;
use Yard\Hook\Filter;

class PatternContent
{
	private array $patterns = [];

	public function __construct()
	{
		$this->patterns = config('components.hooks.pattern_content.patterns', []);
	}

	/**
	 * Automatically set the specified block patterns as draft after saving.
	 */
	#[Action('wp_insert_post_data', 10, 3)]
	public function savePatternsAsDraft(array $data, array $postArray, array $post): array
	{
		if ('auto-draft' === $data['post_status'] || ! isset($post['post_name'], $post['post_type'])) {
			return $data;
		}

		if ('wp_block' === $post['post_type']) {
			$patternConfig = $this->patterns[$post['post_name']] ?? [];

			if ($patternConfig['save_as_draft'] ?? false ) {
				$data['post_status'] = 'draft';
			}
		}

		return $data;
	}

	/**
	 * Prevent deleting the specified block patterns in the admin post list.
	 */
	#[Filter('post_row_actions', 10, 2)]
	public function disablePatternDeletion(array $actions, WP_Post $post): array
	{
		if ('wp_block' !== $post->post_type) {
			return $actions;
		}

		$patternConfig = $this->patterns[$post->post_name] ?? null;

		if ($patternConfig && ! empty($patternConfig['disable_deletion'])) {
			unset($actions['trash']);
		}

		return $actions;
	}

	/**
	 * Prevent deletion of the specified block patterns entirely.
	 */
	#[Action('before_delete_post')]
	public function preventPatternDeletion(int $postId): void
	{
		$post = get_post($postId);

		if (! $post || 'wp_block' !== $post->post_type) {
			return;
		}

		$patternConfig = $this->patterns[$post->post_name] ?? null;

		if ($patternConfig && ! empty($patternConfig['disable_deletion'])) {
			wp_die('Het is niet mogelijk om dit patroon te verwijderen.', '', ['response' => 403]);
		}
	}

	/**
	 * Add a custom label to the specified block patterns in the admin list.
	 */
	#[Filter('display_post_states')]
	public function addCustomPatternLabel(array $postStates, WP_Post $post): array
	{
		if ('wp_block' !== $post->post_type) {
			return $postStates;
		}

		$patternConfig = $this->patterns[$post->post_name] ?? null;

		if ($patternConfig && ! empty($patternConfig['custom_label'])) {
			$postStates['draft'] = $patternConfig['custom_label'];
		}

		return $postStates;
	}
}
