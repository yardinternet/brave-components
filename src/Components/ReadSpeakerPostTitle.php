<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use Illuminate\View\Component;
use Illuminate\View\Factory;
use Illuminate\View\View;

class ReadSpeakerPostTitle extends Component
{
	public function render(): View|Factory|string
	{
		return view('brave::components.read-speaker-post-title');
	}
}
