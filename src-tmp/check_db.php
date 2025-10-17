<?php
// One-off script to bootstrap Laravel and list sqlite tables
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

// Bootstrap the application (like artisan does)
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "DB path: " . config('database.connections.sqlite.database') . PHP_EOL;

try {
    $tables = \DB::select("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name;");
    if (is_array($tables)) {
        echo "Tables:\n";
        foreach ($tables as $t) {
            // each row is an object with property 'name'
            if (is_object($t)) {
                echo " - " . ($t->name ?? json_encode($t)) . PHP_EOL;
            } else {
                echo " - " . json_encode($t) . PHP_EOL;
            }
        }
    } else {
        echo "No tables returned\n";
    }
} catch (\Exception $e) {
    echo "Error querying sqlite_master: " . $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}

exit(0);
