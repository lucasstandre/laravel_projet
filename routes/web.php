<?php

use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChansonController;
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
});

// Route des controlleurs

Route::controller(PlaylistController::class)->group(function() {
    Route::get('/playlists', 'index')->name('playlists');
    Route::get('/playlist/{id}', 'show')->name('playlist');
    Route::get('/link/{link}', 'playlistLink')->name('playlistLink');
    Route::get('/modification/playlist', 'edit')->name('modificationPlaylist');
    Route::post('/enregistrement/playlist', 'update')->name('enregistrementPlaylist');
});

Route::middleware('auth')->controller(PlaylistController::class)->group(function() {
    Route::get('/mesPlaylists', 'mesPlaylists')->name('mesPlaylists');
});

// Route pour rechercher un utilisateur dans le menu navigation
Route::controller(UserController::class)->group(function() {
    Route::get('/users', 'index')->name('users');
    Route::get('/users/{user}', 'show')->name('users');
});


// Route pour quand on recherche un utilisateur
Route::controller(UserController::class)->group(function() {
    Route::get('/users', 'index')->name('users.show');
    Route::get('/users/{user}', 'show')->name('users');
});

// Route pour la gestion des utilisateurs (CRUD)
Route::controller(UserController::class)->group(function() {
    Route::get('/users', 'index')->name('users.index');
    Route::get('/users/{user}', 'show')->name('users.show');
});

<<<<<<< HEAD
Route::controller(ChansonController::class)->group(function(){
    Route::get('/chansons', 'index')->name('chansons');

    Route::get('/chansons/create', 'create')->name('chansons.create');
    Route::post('/chansons', 'store')->name('chansons.store');

    Route::get('/chansons/{chanson}/edit', 'edit')->name('chansons.edit');
    Route::put('/chansons/{chanson}', 'update')->name('chansons.update');

    Route::delete('/chansons/{chanson}', 'destroy')->name('chansons.destroy');

    Route::get('/chansons/{chanson}', 'show')->name('chanson');
});

Route::controller(AlbumController::class)->group(function(){
    Route::get('/albums', 'index')->name('albums');


});

Route::middleware('auth')->controller(UserController::class)->group(function() {
=======
// Seul role admin peut accéder à ces routes
Route::middleware(['auth', 'admin'])->controller(UserController::class)->group(function() {
>>>>>>> feature/users-page
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
Route::controller(MediaSociaux::class)->group(function() {
    Route::get('/media-sociaux', 'index')->name('media-sociaux.index');
    Route::get('/media-sociaux/create', 'create')->name('media-sociaux.create');
    Route::post('/media-sociaux', 'store')->name('media-sociaux.store');
    Route::get('/media-sociaux/{id}', 'show')->name('media-sociaux.show');
    Route::get('/media-sociaux/{id}/edit', 'edit')->name('media-sociaux.edit');
    Route::put('/media-sociaux/{id}', 'update')->name('media-sociaux.update');
    Route::delete('/media-sociaux/{id}', 'destroy')->name('media-sociaux.destroy');
});


require __DIR__.'/auth.php';
