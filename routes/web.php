<?php

use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChansonController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MediaSociaux as MediaSociauxController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- SECTION PROFIL ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/media', [ProfileController::class, 'storeMediaSocial'])->name('profile.media.store');
    Route::put('/profile/media/{mediaSocial}', [ProfileController::class, 'updateMediaSocial'])->name('profile.media.update');
    Route::delete('/profile/media/{mediaSocial}', [ProfileController::class, 'destroyMediaSocial'])->name('profile.media.destroy');

    Route::post('/profile/country', [CountryController::class, 'updateUserCountry'])->name('profile.country.update');
    Route::delete('/profile/country', [CountryController::class, 'deleteUserCountry'])->name('profile.country.delete');

    Route::post('/profile/subscription', [SubscriptionController::class, 'store'])->name('profile.subscription.store');
    Route::put('/profile/subscription', [SubscriptionController::class, 'update'])->name('profile.subscription.update');
    Route::delete('/profile/subscription', [SubscriptionController::class, 'destroy'])->name('profile.subscription.destroy');
});

// --- SECTION ALBUMS ---
Route::controller(AlbumController::class)->group(function(){
    Route::get('/albums', 'index')->name('albums');
    Route::get('/albums/{album}', 'show')->name('album');
});

Route::middleware('auth')->controller(AlbumController::class)->group(function(){
    Route::get('/albums/create', 'create')->name('albums.create');
    Route::post('/albums', 'store')->name('albums.store');
    Route::get('/albums/{album}/edit', 'edit')->name('albums.edit');
    Route::put('/albums/{album}', 'update')->name('albums.update');
    Route::delete('/albums/{album}', 'destroy')->name('albums.destroy');
});

// --- SECTION CHANSONS ---
Route::controller(ChansonController::class)->group(function(){
    Route::get('/chansons', 'index')->name('chansons');
    Route::get('/chansons/create', 'create')->name('chansons.create');
    Route::post('/chansons', 'store')->name('chansons.store');
    Route::get('/chansons/{chanson}', 'show')->name('chanson');
});

Route::middleware('auth')->controller(ChansonController::class)->group(function(){
    Route::get('/chansons/{chanson}/edit', 'edit')->name('chansons.edit');
    Route::put('/chansons/{chanson}', 'update')->name('chansons.update');
    Route::delete('/chansons/{chanson}', 'destroy')->name('chansons.destroy');
    Route::patch('/chansons/{chanson}/retirer-album', 'retirerAlbum')->name('chansons.retirerAlbum');
});

// Settings
Route::get('/settings', function() {
    return view('chanson.settings');
})->name('settings');

Route::middleware('auth')->delete('/account', [UserController::class, 'destroyAccount'])->name('account.destroy');

// --- SECTION PLAYLISTS ---
Route::controller(PlaylistController::class)->group(function() {
    Route::get('/playlists', 'index')->name('playlists');
    Route::get('/playlist/{id}', 'show')->name('playlist');
    Route::get('/link/{link}', 'playlistLink')->name('playlistLink');
    Route::get('/modification/playlist', 'edit')->name('modificationPlaylist');
    Route::post('/enregistrement/playlist', 'update')->name('enregistrementPlaylist');
});

Route::middleware('auth')->controller(PlaylistController::class)->group(function() {
    Route::get('/mes-playlists', 'mesPlaylists')->name('mes-playlists');
});

// --- SECTION USERS / ROLES / STATUS ---
Route::controller(UserController::class)->group(function() {
    Route::get('/users', 'index')->name('users.index');
    Route::get('/users/{user}', 'show')->name('users.show');
});

Route::middleware(['auth', 'admin'])->controller(UserController::class)->group(function() {
    Route::get('/users/create', 'create')->name('users.create');
    Route::post('/users', 'store')->name('users.store');
    Route::get('/users/{user}/edit', 'edit')->name('users.edit');
    Route::put('/users/{user}', 'update')->name('users.update');
    Route::delete('/users/{user}', 'destroy')->name('users.destroy');
});

Route::middleware(['auth', 'admin'])->controller(StatusController::class)->group(function() {
    Route::put('/users/{user}/status', 'update')->name('users.status.update');
});

Route::middleware(['auth', 'admin'])->controller(RoleController::class)->group(function() {
    Route::put('/users/{user}/role', 'update')->name('users.role.update');
});

// --- SECTION STATISTIQUES ---
Route::middleware('auth')->prefix('statistics')->controller(StatisticController::class)->group(function () {
    Route::get('/user/{id?}', 'userStats')->name('statisticsUserApi');
    Route::get('/artist/{id?}', 'artistStats')->name('statisticsArtistApi');
});

Route::middleware('auth')->controller(StatisticController::class)->group(function () {
    Route::get('/statistique/user/{id?}', 'showUser')->name('statistique.user');
    Route::get('/statistique/artist/{id?}', 'showArtist')->name('statistique.artist');
});

// --- SECTION MEDIAS SOCIAUX ---
Route::resource('mediasociaux', MediaSociauxController::class)->except(['show']);

require __DIR__.'/auth.php';
