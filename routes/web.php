<?php

use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChansonController;
use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaSociaux;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\SubscriptionController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour gérer les médias sociaux
    Route::post('/profile/media', [ProfileController::class, 'storeMediaSocial'])->name('profile.media.store');
    Route::put('/profile/media/{mediaSocial}', [ProfileController::class, 'updateMediaSocial'])->name('profile.media.update');
    Route::delete('/profile/media/{mediaSocial}', [ProfileController::class, 'destroyMediaSocial'])->name('profile.media.destroy');

    // Routes pour gérer le pays
    Route::post('/profile/country', [CountryController::class, 'updateUserCountry'])->name('profile.country.update');
    Route::delete('/profile/country', [CountryController::class, 'deleteUserCountry'])->name('profile.country.delete');

    // Routes pour gérer l'abonnement
    Route::post('/profile/subscription', [SubscriptionController::class, 'store'])->name('profile.subscription.store');
    Route::put('/profile/subscription', [SubscriptionController::class, 'update'])->name('profile.subscription.update');
    Route::delete('/profile/subscription', [SubscriptionController::class, 'destroy'])->name('profile.subscription.destroy');
});

Route::controller(PlaylistController::class)->group(function() {
    Route::get('/playlists', 'index')->name('playlists');
    Route::get('/playlist/{id}', 'show')->name('playlist');
});

// Route pour la gestion des utilisateurs (CRUD)
Route::controller(UserController::class)->group(function() {
    Route::get('/users', 'index')->name('users.index');
    Route::get('/users/{user}', 'show')->name('users.show');
});

// Route de debug
Route::get('/debug-users', function() {
    $users = \App\Models\User::with('country')->limit(5)->get();
    $debug = [];
    foreach($users as $user) {
        $debug[] = [
            'id' => $user->id,
            'name' => $user->name,
            'id_country' => $user->id_country,
            'country_attr' => $user->getAttribute('country'),
            'country_relation' => $user->country ? $user->country->name_country : null,
            'all_attributes' => $user->getAttributes(),
        ];
    }
    return response()->json($debug);
});

// Test subscription structure
Route::get('/test-subscription', function() {
    $user = \App\Models\User::first();
    if (!$user) {
        return response()->json(['error' => 'No users found']);
    }

    $subscription = $user->subscription;
    $tables = \Illuminate\Support\Facades\DB::select("DESCRIBE subscriptions");

    return response()->json([
        'user_id' => $user->id,
        'subscription' => $subscription ? $subscription->getAttributes() : null,
        'table_structure' => array_map(function($col) {
            return $col->Field . ' (' . $col->Type . ')';
        }, $tables),
    ]);
});

// Seul role admin peut accéder à ces routes
Route::middleware(['auth', 'admin'])->controller(UserController::class)->group(function() {
    Route::get('/users/create', 'create')->name('users.create');
    Route::post('/users', 'store')->name('users.store');
    Route::get('/users/{user}/edit', 'edit')->name('users.edit');
    Route::put('/users/{user}', 'update')->name('users.update');
    Route::delete('/users/{user}', 'destroy')->name('users.destroy');
});

// seul role admin peut accéder à ces routes pour changer le status et le role d'un utilisateur
Route::middleware(['auth', 'admin'])->controller(StatusController::class)->group(function() {
    Route::put('/users/{user}/status', 'update')->name('users.status.update');
});

// seul role admin peut accéder à ces routes pour changer le role d'un utilisateur
Route::middleware(['auth', 'admin'])->controller(RoleController::class)->group(function() {
    Route::put('/users/{user}/role', 'update')->name('users.role.update');
});

Route::middleware('auth')->prefix('statistics')->controller(StatisticController::class)->group(function () {
    Route::get('/user/{id?}', 'userStats')->name('statisticsUserApi');
    Route::get('/artist/{id?}', 'artistStats')->name('statisticsArtistApi');
});

Route::middleware('auth')->controller(StatisticController::class)->group(function () {
    Route::get('/statistique/user/{id?}', 'showUser')->name('statistique.user');
    Route::get('/statistique/artist/{id?}', 'showArtist')->name('statistique.artist');
});
// Routes pour les médias sociaux
use App\Http\Controllers\MediaSociaux as MediaSociauxController;
Route::resource('mediasociaux', MediaSociauxController::class)->except(['show']);

require __DIR__.'/auth.php';
