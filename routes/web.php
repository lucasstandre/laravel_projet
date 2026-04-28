<?php

use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaSociaux;

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


// Routes pour les médias sociaux
use App\Http\Controllers\MediaSociaux as MediaSociauxController;
Route::resource('mediasociaux', MediaSociauxController::class)->except(['show']);


require __DIR__.'/auth.php';
