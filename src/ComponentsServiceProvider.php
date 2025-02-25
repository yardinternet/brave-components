<?php

declare(strict_types=1);

namespace Yard\Brave;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Yard\Hook\Registrar;
use Yard\Brave\Components\PatternContent;

class ComponentsServiceProvider extends PackageServiceProvider
{
	public function configurePackage(Package $package): void
	{
		$package
			->name('components')
			->hasConfigFile()
			->hasViews('brave')
			->hasViewComponent('brave', PatternContent::class);
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
