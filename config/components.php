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
				// Add more patterns as needed
			],
		],
	],
	'feedbackFormId' => env('FEEDBACK_FORM_ID'),
];
