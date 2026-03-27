<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use Illuminate\View\Component;
use Illuminate\View\Factory;
use Illuminate\View\View;

class ReadSpeaker extends Component
{
	public int $customerId;
	public string $readId;
	public string $disable;

	public function __construct()
	{
		$this->customerId = (int) config('components.readSpeaker.customerId', 0);
		$this->readId = config('components.readSpeaker.readId', 'main');
		$this->disable = config('components.readSpeaker.disable', '');
	}

	public function render(): View|Factory|string
	{
		if (0 === $this->customerId) {
			return '';
		}

		return view('brave::components.read-speaker');
	}
}
