<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Ensure sqlite database file exists when using sqlite and PATH is absolute (helps Railway)
if (file_exists(__DIR__.'/../.env')) {
    $env = trim(file_get_contents(__DIR__.'/../.env'));
    if (strpos($env, 'DB_CONNECTION=sqlite') !== false) {
        preg_match('/DB_DATABASE=\s*(.+)/', $env, $m);
        if (!empty($m[1])) {
            $dbPath = trim($m[1]);
            // If path looks absolute (starts with /), try to create file
            if (strlen($dbPath) && $dbPath[0] === '/' ) {
                $full = $dbPath;
                if (!file_exists($full)) {
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
