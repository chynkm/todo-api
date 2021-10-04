<?php

// change to 0 in production
error_reporting(E_ALL);
ini_set('display_errors', '1');

$settings['root'] = dirname(__DIR__);

// Error Handling Middleware settings
$settings['error'] = [

    // change to false in production
    'display_error_details' => true,
    'log_errors' => true,
    'log_error_details' => true,
];

$settings['view'] = [
    'path' => __DIR__ . '/../templates',
];

return $settings;
