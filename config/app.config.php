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

$css_path = $app_url . '/css';
$assets_path = $app_url . '/assets';
$js_path = $app_url . '/js';

define('APP_URL', $app_url);

define('CSS_PATH', $css_path);
define('ASSETS_PATH', $assets_path);
define('JS_PATH', $js_path);
