<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::with('country')->first();
if ($user) {
    echo "User: " . $user->name . "\n";
    echo "ID Country: " . $user->id_country . "\n";
    echo "Country relation: " . json_encode($user->country) . "\n";
} else {
    echo "No users found\n";
}
