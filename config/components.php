<?php

return [
    'hooks' => [
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
];
