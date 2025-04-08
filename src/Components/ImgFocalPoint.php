<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\Component;
use Illuminate\View\View;

class ImgFocalPoint extends Component
{
	public string $focalPoint = '';
	public string $src = '';

	public function __construct(
		public int $id,
		public string $size = 'medium_large',
		public string $alt = '',
		public string $position = 'object-position', //Kan dit weg??
		public string $loading = 'lazy',
		public string $fetchPriority = '',
		string $src = '',
	) {
		$this->src = '' === $src ? $this->getImageURL($id, $size) : $src;
		$this->focalPoint = $this->calculateFocalPoint($id, $position);
	}

	public function render(): View|Factory|string
	{
		if (empty($this->focalPoint)) {
			return '';
		}

		return view('brave::components.img-focal-point');
	}

	public function calculateFocalPoint(int $id, string $position): string
	{
		if (! function_exists('get_field')) {
			$focalPoint = [
				'x' => 0.5,
				'y' => 0.5,
			];
		} else {
			$metaValue = get_field('featured_image_focal_point', $id, false) ?: '';
			$focalPoint = [
				'x' => $metaValue['x'] ?? 0.5,
				'y' => $metaValue['y'] ?? 0.5,
			];
		}

		return sprintf(
			'%s:%d%% %d%%;',
			$position,
			$focalPoint['x'] * 100,
			$focalPoint['y'] * 100
		);
	}

	public function getImageURL(int $id, string $size): string
	{
		return get_the_post_thumbnail_url($id, $size) ?: '';
	}
}
