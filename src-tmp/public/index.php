<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Ensure sqlite database file exists when using sqlite (absolute or relative paths)
if (file_exists(__DIR__.'/../.env')) {
    $env = trim(file_get_contents(__DIR__.'/../.env'));
    if (strpos($env, 'DB_CONNECTION=sqlite') !== false) {
        preg_match('/DB_DATABASE=\s*(.+)/', $env, $m);
        if (!empty($m[1])) {
            $dbPath = trim($m[1]);
            if (strlen($dbPath)) {
                // If path looks absolute (starts with /), use as-is. Otherwise resolve relative to project root
                if ($dbPath[0] === '/' ) {
                    $full = $dbPath;
                } else {
                    $full = realpath(__DIR__.'/..') . DIRECTORY_SEPARATOR . $dbPath;
                }
                if ($full && !file_exists($full)) {
                    @mkdir(dirname($full), 0755, true);
                    @touch($full);
                }
            }
        }
    }
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
