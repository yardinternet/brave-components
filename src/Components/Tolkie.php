<?php

namespace Yard\Brave\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\Component;
use Illuminate\View\View;

class Tolkie extends Component
{
	public function render(): Factory|View
	{
		return view('brave::components.tolkie');
	}
}
