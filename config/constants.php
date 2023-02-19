<?php

/**
 * Configure constants used in the application.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

if($_ENV['USE_SSL'] == 0)
{
    $prefix = 'http://';
}
else
{
    $prefix = 'https://';
}

define('BASE_URL', $prefix . $_ENV['DOMAIN'] . ':' . $_ENV['PORT']);

define('APP_PATH', __DIR__ . '/../src');
define('CONFIG_PATH', __DIR__ . '/../config');
define('STORAGE_PATH', __DIR__ . '/../var');
define('VIEWS_PATH', __DIR__ . '/../resources/views');

define('CSS_URL', '/css');
define('ASSETS_URL', '/assets');
define('HTMX_URL', '/htmx/htmx.min.js');