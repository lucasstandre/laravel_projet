<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DEBUG UTILISATEURS ===\n\n";

$users = \App\Models\User::limit(5)->get();

foreach($users as $user) {
    echo "User ID: {$user->id}\n";
    echo "  Name: {$user->name}\n";
    echo "  Attributes: " . json_encode($user->getAttributes()) . "\n";
    echo "  id_country: " . ($user->id_country ?? 'NULL') . "\n";
    echo "  country (attr): " . ($user->getAttribute('country') ?? 'NULL') . "\n";
    echo "  country_name: " . ($user->country_name ?? 'NULL') . "\n";
    echo "\n";
}

echo "=== INFO COUNTRIES ===\n";
$countries = \App\Models\Country::limit(3)->get();
foreach($countries as $country) {
    echo "Country ID: {$country->id_country}, Name: {$country->name_country}\n";
}
