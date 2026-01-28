<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\Component;
use Illuminate\View\View;

class Dialog extends Component
{
	public function render(): Factory|View
	{
		return view('brave::components.dialog.index');
	}
}
