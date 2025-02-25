<?php

declare(strict_types=1);

namespace Yard\Brave\Hooks;

use Yard\Hook\Action;
use Yard\Hook\Filter;

class FooterPatternContent
{
	/**
	 * Automatically set the 'footer' block pattern as draft after saving.
	 */
	#[Action('wp_insert_post_data', 10, 3)]
	public function saveFooterPatternAsDraft(array $data, array $postArray, array $post): array
	{
		if ('auto-draft' === $data['post_status']) {
			return $data;
		}

		if (isset($post['post_name'], $post['post_type']) && 'footer' === $post['post_name'] && 'wp_block' === $post['post_type']) {
			$data['post_status'] = 'draft';
		}

		return $data;
	}

	/**
	 * Prevent deleting the 'footer' block in the admin post list.
	 */
	#[Filter('post_row_actions', 10, 2)]
	public function disableFooterPatternDeletion(array $actions, \WP_Post $post): array
	{
		if ('wp_block' === $post->post_type && 'footer' === $post->post_name) {
			unset($actions['trash']);
		}

		return $actions;
	}

	/**
	 * Prevent deletion of the 'footer' pattern entirely.
	 */
	#[Action('before_delete_post')]
	public function preventFooterPatternDeletion(int $postId): void
	{
		$post = get_post($postId);

		if ($post && 'wp_block' === $post->post_type && 'footer' === $post->post_name) {
			wp_die(__('Het is niet mogelijk om de footer patroon te verwijderen.', 'sage'), '', ['response' => 403]);
		}
	}

	/**
	 * Add a custom label to the 'footer' block in the post list.
	 */
	#[Filter('display_post_states')]
	public function addCustomFooterBlockLabel(array $postStates, \WP_Post $post): array
	{
		if ('wp_block' === $post->post_type && 'footer' === $post->post_name) {
			$postStates['draft'] = __('Vergrendeld', 'sage');
		}

		return $postStates;
	}
}
