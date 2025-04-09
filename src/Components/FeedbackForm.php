<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use GFForms;
use Illuminate\View\Component;
use Illuminate\View\Factory;
use Illuminate\View\View;

class FeedbackForm extends Component
{
	public string $form = '';
	public int $id;

	public function __construct(
		public bool $displayTitle = false,
		public bool $displayDescription = false,
		public bool $ajax = true,
	) {
		$this->id = (int) config('components.feedbackFormId');
		$this->form = $this->getFeedbackForm();
	}

	protected function getFeedbackForm(): string
	{
		if (! method_exists(GFForms::class, 'get_form')) {
			return '';
		}

        if(0 === $this->id) {
            return '';
        }

		return GFForms::get_form(
			$this->id,
			$this->displayTitle,
			$this->displayDescription,
			$this->ajax,
		);
	}

	public function render(): View|Factory|string
	{
		if (0 === strlen($this->form) || is_front_page()) {
			return '';
		}

		return view('brave::components.feedback-form');
	}
}
