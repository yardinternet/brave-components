<?php

declare(strict_types=1);

namespace Yard\Brave\Support;

use Yard\Brave\Hooks\ReadSpeaker as ReadSpeakerHook;

class ReadSpeaker
{
	public static function isEnabled(): bool
	{
		return 0 !== (int) (config('components.read_speaker.customer_id') ?? config('components.readSpeaker.customerId', 0));
	}

	public static function showBefore(): bool
	{
		return ReadSpeakerHook::POSITION_BEFORE === config('components.read_speaker.h1_position');
	}

	public static function showAfter(): bool
	{
		return ! static::showBefore();
	}
}
