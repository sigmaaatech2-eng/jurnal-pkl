<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Prepare writable /tmp directories for Vercel Serverless environment
$tmpStorage = '/tmp/storage';
if (!is_dir($tmpStorage . '/framework/views')) {
    @mkdir($tmpStorage . '/framework/views', 0755, true);
    @mkdir($tmpStorage . '/framework/cache/data', 0755, true);
    @mkdir($tmpStorage . '/framework/sessions', 0755, true);
    @mkdir($tmpStorage . '/logs', 0755, true);
}

// Set environment variables for serverless compatibility
putenv("VIEW_COMPILED_PATH={$tmpStorage}/framework/views");
putenv("APP_SERVICES_CACHE={$tmpStorage}/bootstrap-services.php");
putenv("APP_PACKAGES_CACHE={$tmpStorage}/bootstrap-packages.php");
putenv("APP_CONFIG_CACHE={$tmpStorage}/bootstrap-config.php");
putenv("APP_ROUTES_CACHE={$tmpStorage}/bootstrap-routes.php");
putenv("APP_EVENTS_CACHE={$tmpStorage}/bootstrap-events.php");

if (empty($_ENV['LOG_CHANNEL']) && empty($_SERVER['LOG_CHANNEL'])) {
    putenv("LOG_CHANNEL=stderr");
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

$app->useStoragePath($tmpStorage);

$app->handleRequest(Request::capture());
