<?php

declare(strict_types=1);

namespace Yard\Brave\Components;

use Illuminate\Support\Facades\URL;
use Illuminate\View\Component;
use Illuminate\View\Factory;
use Illuminate\View\View;

class ReadSpeaker extends Component
{
	public int $customerId;
	public string $readId;
	public string $src = '';

	public function __construct()
	{
		$this->customerId = (int) config('components.read_speaker.customer_id', config('components.readSpeaker.customerId', 0));
		// use old config names as fallback for backwards-compatibility
		$this->readId = config('components.read_speaker.read_id', config('components.readSpeaker.readId', 'main'));

		if (0 !== $this->customerId) {
			$this->src = add_query_arg(
				[
					'customerid' => $this->customerId,
					'lang' => 'nl_nl',
					'readid' => $this->readId,
					'url' => URL::full(),
				],
				'https://app-eu.readspeaker.com/cgi-bin/rsent',
			);
		}
	}

	public function render(): View|Factory|string
	{
		if ('' === $this->src) {
			return '';
		}

		return view('brave::components.read-speaker');
	}
}
