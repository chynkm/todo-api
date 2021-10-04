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

$settings['db'] = [
    'driver' => 'pdo_mysql',
    'host' => 'localhost',
    'dbname' => 'slim',
    'user' => 'homestead',
    'password' => 'secret',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'driverOptions' => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES => true,
        // Set default fetch mode to array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Set character set
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci',
    ],
];

return $settings;
