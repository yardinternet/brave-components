<?php

declare(strict_types=1);

namespace Yard\Brave;

use Yard\Hook\Registrar;
use Yard\Brave\Components\BackButton;
use Spatie\LaravelPackageTools\Package;
use Yard\Brave\Components\PatternContent;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ComponentsServiceProvider extends PackageServiceProvider
{
	public function configurePackage(Package $package): void
	{
		$package
			->name('components')
			->hasConfigFile()
			->hasViews('brave')
			->hasViewComponent('brave', PatternContent::class)
			->hasViewComponent('brave', BackButton::class);
	}

	/**
	 * @throws ReflectionException
	 */
	public function packageBooted(): void
	{
		$hooks = [];

		if (config('components.hooks.pattern_content.enabled', true)) {
			$hooks[] = Hooks\PatternContent::class;
		}

		(new Registrar($hooks))->registerHooks();
	}
}
