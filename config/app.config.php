<?php

/**
 * Contains application configuration and globals
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 05/01/23
 * 
 * @author B Moss
 */

$app_url = dirname($_SERVER['SERVER_NAME']);

$css_path = '/css';
$assets_path = '/assets';
$js_path = '/js';

$log_path = __DIR__ . '/../logs';

define('APP_URL', $app_url);

define('CSS_PATH', $css_path);
define('ASSETS_PATH', $assets_path);
define('JS_PATH', $js_path);

define('LOG_PATH', $log_path);
