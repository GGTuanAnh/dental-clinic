<?php
// Test SQLite PDO
echo "Testing SQLite PDO...\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "PDO Drivers: " . implode(', ', PDO::getAvailableDrivers()) . "\n\n";

if (in_array('sqlite', PDO::getAvailableDrivers())) {
    echo "✅ PDO SQLite is available!\n";
    
    try {
        $pdo = new PDO('sqlite::memory:');
        echo "✅ Successfully created in-memory SQLite database\n";
        $pdo = null;
    } catch (PDOException $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ PDO SQLite is NOT available\n";
    echo "\n📝 To enable PDO SQLite:\n";
    echo "1. Open php.ini file\n";
    echo "2. Find and uncomment (remove ;) these lines:\n";
    echo "   extension=pdo_sqlite\n";
    echo "   extension=sqlite3\n";
    echo "3. Restart your terminal/IDE\n";
    echo "4. Run this script again\n";
}
