<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('prints an inline script through WordPress, without its null attributes', function () {
	WP_Mock::userFunction('wp_print_inline_script_tag', [
		'times' => 1,
		'args' => ['window.example = 1;', ['id' => 'example']],
		'return' => function (string $data, array $attributes): void {
			echo sprintf('<script id="%s">%s</script>', $attributes['id'], $data);
		},
	]);

	expect(Blade::render('<x-brave-inline-script id="example" :data-skip="null">window.example = 1;</x-brave-inline-script>'))
		->toBe('<script id="example">window.example = 1;</script>');
});
