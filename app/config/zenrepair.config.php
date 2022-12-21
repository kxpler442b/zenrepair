<?php

/**
 * zenrepair.config.php
 * 
 * contains settings for the application and its dependencies
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 26/11/22
 * 
 * @author B Moss
 */

$pb_config = require $config_path . '/pocketbase.config.php';
define('PB_CONFIG', $pb_config);

$app_url = dirname($_SERVER['SERVER_NAME']);
$css_path = $app_url . '/css';
$assets_path = $app_url . '/assets';
$js_path = $app_url . '/js';

define('APP_URL', $app_url);
define('CSS_PATH', $css_path);
define('ASSETS_PATH', $assets_path);
define('JS_PATH', $js_path);

$settings = [
    "settings" => [
        'displayErrorDetails' => true,
        'view' => [
            'views' => $app_path . '/views',
            'twig' => [
                'debug' => true,
                'cache' => false
            ],
        ],
    ],
];

return $settings;