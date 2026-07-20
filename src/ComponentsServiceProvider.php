<?php

declare(strict_types=1);

namespace Yard\Brave;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Yard\Brave\Components\Accordion;
use Yard\Brave\Components\BackButton;
use Yard\Brave\Components\Breadcrumb;
use Yard\Brave\Components\Dialog;
use Yard\Brave\Components\FeedbackForm;
use Yard\Brave\Components\ImgFocalPoint;
use Yard\Brave\Components\Nav;
use Yard\Brave\Components\PatternContent;
use Yard\Brave\Components\ReadSpeaker;
use Yard\Brave\Components\SocialIcon;
use Yard\Brave\Components\Tooltip;
use Yard\Hook\Registrar;

class ComponentsServiceProvider extends PackageServiceProvider
{
	public function configurePackage(Package $package): void
	{
		$package
			->name('components')
			->hasConfigFile()
			->hasViews('brave')
			->hasViewComponents(
				'brave',
				Accordion::class,
				BackButton::class,
				Breadcrumb::class,
				Dialog::class,
				FeedbackForm::class,
				ImgFocalPoint::class,
				Nav::class,
				PatternContent::class,
				ReadSpeaker::class,
				SocialIcon::class,
				Tooltip::class
			);
	}

	public function packageBooted(): void
	{
		$hooks = [];

		if (config('components.hooks.pattern_content.enabled', true)) {
			$hooks[] = Hooks\PatternContent::class;
		}

		if (0 !== (int) config('components.readSpeaker.customerId', 0)) {
			$hooks[] = Hooks\ReadSpeaker::class;
		}

		if ('' !== config('tolkie.token', '')) {
			$hooks[] = Hooks\Tolkie::class;
		}

		(new Registrar($hooks))->registerHooks();
	}
}
