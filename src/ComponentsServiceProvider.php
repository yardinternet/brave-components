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
use Yard\Brave\Components\PatternContent;
use Yard\Brave\Components\SocialIcon;
use Yard\Hook\Registrar;

class ComponentsServiceProvider extends PackageServiceProvider
{
	public function configurePackage(Package $package): void
	{
		$package
			->name('components')
			->hasConfigFile()
			->hasViews('brave')
			->hasViewComponents('brave', Accordion::class, BackButton::class, Breadcrumb::class, Dialog::class, FeedbackForm::class,  ImgFocalPoint::class, PatternContent::class, SocialIcon::class);
	}

	public function packageBooted(): void
	{
		$hooks = [];

		if (config('components.hooks.pattern_content.enabled', true)) {
			$hooks[] = Hooks\PatternContent::class;
		}

		(new Registrar($hooks))->registerHooks();
	}
}
