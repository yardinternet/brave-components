<?php

declare(strict_types=1);

namespace Yard\Brave\Hooks;

use Yard\Hook\Action;

class FocalPoint {

	#[Action('init')]
	public function registerFeaturedImageFocalPoint(): void {
		register_post_meta('', 'featured_image_focal_point', [
			'type' => 'object',
			'description' => __('Focuspunt van de uitgelichte afbeelding', 'sage'),
			'single' => true,
			'show_in_rest' => [
				'schema' => [
					'type' => 'object',
					'properties' => [
						'x' => [
							'type' => 'number',
							'default' => 0.5,
						],
						'y' => [
							'type' => 'number',
							'default' => 0.5,
						],
					],
				],
			],
		]);
	}
	#[Action('post_thumbnail_html')]
	public function addFocalPointToFeaturedImageHtml(string $html, int $postID): string {
		if (strlen($html) === 0) {
			return $html;
		}

		$focalPoint = get_post_meta($postID, 'featured_image_focal_point', true);

		if (!is_array($focalPoint) || !isset($focalPoint['x']) || !isset($focalPoint['y'])) {
			return $html;
		}

		$objectPosition = sprintf('object-position: %d%% %d%%;', $focalPoint['x'] * 100, $focalPoint['y'] * 100);

		$doc = new \DOMDocument();
		libxml_use_internal_errors(true);
		if (!$doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD)) {
			libxml_clear_errors();

			return $html; // Return original HTML if loading fails
		}
		libxml_clear_errors();

		$images = $doc->getElementsByTagName('img');

		foreach ($images as $img) {
			$style = $img->getAttribute('style');
			$img->setAttribute('style', $style.' '.$objectPosition);
		}

		return $doc->saveHTML();
	}
}
