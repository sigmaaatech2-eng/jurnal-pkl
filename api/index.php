<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Ensure /tmp storage structure for Vercel serverless environment
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    $storagePath = '/tmp/storage';
    if (!is_dir($storagePath . '/framework/views')) {
        @mkdir($storagePath . '/framework/views', 0755, true);
        @mkdir($storagePath . '/framework/cache/data', 0755, true);
        @mkdir($storagePath . '/framework/sessions', 0755, true);
        @mkdir($storagePath . '/logs', 0755, true);
    }
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
    $app->useStoragePath('/tmp/storage');
}

$app->handleRequest(Request::capture());
