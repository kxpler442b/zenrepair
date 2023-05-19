<?php

/**
 * Return an array containing the application settings.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

return [
    'displayErrorDetails' => true,
    'logErrors' => false,
    'logErrorDetails' => false,
    'doctrine' => require CONFIG_PATH . '/database.php',
    'session' => [
        'secure' => false,
        'httponly' => true,
        'samesite' => 'lax'
    ]
];