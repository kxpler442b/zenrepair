<?php

/**
 * Application configuration
 * 
 * Author: B Moss
 * Email: <P2595849@my365.dmu.ac.uk>
 * Date: 15/01/23
 * 
 * @author B Moss
 */

declare(strict_types = 1);

return [
    'settings' => [
        'slim' => [
            // Returns a detailed HTML page with error details and
            // a stack trace. Should be disabled in production.
            'displayErrorDetails' => true,

            // Whether to display errors on the internal PHP log or not.
            'logErrors' => true,

            // If true, display full errors with message and stack trace on the PHP log.
            // If false, display only "Slim Application Error" on the PHP log.
            // Doesn't do anything when 'logErrors' is false.
            'logErrorDetails' => true,
        ],
    ]
];