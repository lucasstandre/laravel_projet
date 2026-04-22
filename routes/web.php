<?php

use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChansonController;
use Illuminate\Support\Facades\Route;

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

Route::controller(UserController::class)->group(function() {
    Route::get('/users', 'index')->name('users.index');
    Route::get('/users/{user}', 'show')->name('users.show');
});

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
    Route::get('/users/create', 'create')->name('users.create');
    Route::post('/users', 'store')->name('users.store');
    Route::get('/users/{user}/edit', 'edit')->name('users.edit');
    Route::put('/users/{user}', 'update')->name('users.update');
    Route::delete('/users/{user}', 'destroy')->name('users.destroy');
});

Route::middleware('auth')->controller(StatusController::class)->group(function() {
    Route::put('/users/{user}/status', 'update')->name('users.status.update');
});

Route::middleware('auth')->controller(RoleController::class)->group(function() {
    Route::put('/users/{user}/role', 'update')->name('users.role.update');
});

require __DIR__.'/auth.php';
