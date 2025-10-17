<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$email = 'apitest@example.com';
$password = 'secret123';

$user = User::firstOrCreate([
    'email' => $email
], [
    'name' => 'API Test',
    'password' => bcrypt($password),
    'role' => 'admin'
]);

$token = $user->createToken('cli-token')->plainTextToken;
echo "CREATED_USER_EMAIL={$email}\n";
echo "PASSWORD={$password}\n";
echo "TOKEN={$token}\n";
