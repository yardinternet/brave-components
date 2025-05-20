<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\Component;
use Illuminate\View\View;

class Accordion extends Component
{
	public function render(): Factory|View
	{
		return view('brave::components.accordion.index');
	}
}
