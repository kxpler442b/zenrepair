<?php

declare(strict_types = 1);

return [
    'settings' => [
        'displayErrorDetails' => True,
        'determineRouteBeforeAppMiddleware' => False,
        'twig' => [
            'cache' => STORAGE_PATH . '/cache/twig',
            'auto_reload' => True,
            'displayErrorDetails' => True
        ],
    ]
];