<?php

declare(strict_types=1);

return [
	'hooks' => [
		'pattern_content' => [
			'enabled' => true,
			'patterns' => [
				'footer' => [
					'save_as_draft' => true,
					'disable_deletion' => true,
					'custom_label' => 'Vergrendeld',
				],
				// Add more patterns as needed
			],
		],
	],
];
