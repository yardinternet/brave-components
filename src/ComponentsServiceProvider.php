<?php

declare(strict_types=1);

namespace Yard\Brave;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Yard\Hook\Registrar;
use Yard\Brave\Components\FooterPatternContent;

class ComponentsServiceProvider extends PackageServiceProvider
{
	public function configurePackage(Package $package): void
	{
		$package
			->name('components')
			->hasConfigFile()
			->hasViews('brave')
			->hasViewComponent('brave', FooterPatternContent::class);
	}

	/**
	 * @throws ReflectionException
	 */
	public function packageBooted(): void
	{
		$hooks = [];

		if (config('components.hooks.footer_pattern_content')) {
			$hooks[] = Hooks\FooterPatternContent::class;
		}

		(new Registrar($hooks))->registerHooks();
	}
}
