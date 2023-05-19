<?php

/**
 * Configure constants used in the application.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

if($_ENV['RSMS_APP_SSL'] == 0)
{
    $prefix = 'http://';
}
else
{
    $prefix = 'https://';
}

define('BASE_URL', $prefix . $_ENV['RSMS_APP_BASE_URL']);

define('APP_PATH', __DIR__ . '/../src');
define('CONFIG_PATH', __DIR__);
define('STORAGE_PATH', __DIR__ . '/../var');
define('VIEWS_PATH', __DIR__ . '/../templates');

define('FAVICON_URL', '/favicon.ico');
define('CSS_URL', '/css');
define('ASSETS_URL', '/assets');
define('ICONS_URL', '/icons');
define('HTMX_URL', '/htmx/htmx.min.js');
define('HYPR_URL', '/htmx/hyperscript.min.js');