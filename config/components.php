<?php

declare(strict_types=1);

return [
	'hooks' => [
		'pattern_content' => [
			'enabled' => true,
			'patterns' => [
				'footer' => [
					'save_as_draft' => true,  // Removes the pattern from the pattern-inserter
					'disable_deletion' => true,
					'custom_label' => 'Vergrendeld',
				],
				'404' => [
					'save_as_draft' => true,  // Removes the pattern from the pattern-inserter
					'disable_deletion' => true,
					'custom_label' => 'Vergrendeld',
				],
				// Add more patterns as needed
			],
		],
	],
	'feedback_form_id' => env('FEEDBACK_FORM_ID', ''),
	'breadcrumb' => [
		'labels' => [
			'home' => 'Home',
			'blog' => 'Blog',
			'search' => 'Zoekresultaten',
			'author' => 'Auteur: %s',
			'not_found' => '404 error',
		],
	],
	'read_speaker' => [
		'customer_id' => null,
		'read_id' => 'main',
		'disable' => '',
		'automatically_add_to_h1' => true,
		'h1_position' => 'before', // 'before' or 'after'
	],
	'tolkie' => [
		'token' => null,
		'automatically_add_to_h1' => true,
		'html_attributes' => [
			'data-tolkie-state' => 'separateButtons',
		],
	],
];
