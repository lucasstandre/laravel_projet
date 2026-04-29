<?php

use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChansonController;
use App\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profil Utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- SECTION ALBUMS ---
Route::controller(AlbumController::class)->group(function(){
    Route::get('/albums', 'index')->name('albums');
    Route::get('/albums/{album}', 'show')->name('album'); // Utilisé par albumApi
});

Route::middleware('auth')->controller(AlbumController::class)->group(function(){
    Route::get('/albums/create', 'create')->name('albums.create');
    Route::post('/albums', 'store')->name('albums.store'); // Alias pour insertionAlbumApi
    Route::get('/albums/{album}/edit', 'edit')->name('albums.edit');
    Route::put('/albums/{album}', 'update')->name('albums.update');
    Route::delete('/albums/{album}', 'destroy')->name('albums.destroy');
});

// --- SECTION CHANSONS ---
Route::controller(ChansonController::class)->group(function(){
    Route::get('/chansons/create', 'create')->name('chansons.create');
    //Donner les deux noms
    Route::post('/chansons', 'store')->name('insertionChansonApi');
    Route::post('/chansons', [ChansonController::class, 'store'])->name('chansons.store');


    Route::get('/chansons', 'index')->name('chansons');
    Route::get('/chansons/{chanson}', 'show')->name('chanson'); // Utilisé par chansonApi

    Route::get('/settings', function() {
        return view('chanson.settings');
    })->name('settings');

    Route::delete('/account', [UserController::class, 'destroyAccount'])->name('account.destroy');
});

Route::middleware('auth')->controller(ChansonController::class)->group(function(){

    Route::get('/chansons/{chanson}/edit', 'edit')->name('chansons.edit');
    Route::put('/chansons/{chanson}', 'update')->name('chansons.update');
    Route::delete('/chansons/{chanson}', 'destroy')->name('chansons.destroy');
    Route::patch('/chansons/{chanson}/retirer-album', 'retirerAlbum')->name('chansons.retirerAlbum');
});

// --- SECTION PLAYLISTS ---
Route::controller(PlaylistController::class)->group(function() {
    Route::get('/playlists', 'index')->name('playlists');
    Route::get('/playlist/{id}', 'show')->name('playlist');
});

// --- SECTION USERS / ROLES / STATUS ---
Route::middleware('auth')->group(function() {
    Route::controller(UserController::class)->group(function() {
        Route::get('/users', 'index')->name('users.index');
        Route::get('/users/create', 'create')->name('users.create');
        Route::post('/users', 'store')->name('users.store');
        Route::get('/users/{user}', 'show')->name('users.show');
        Route::get('/users/{user}/edit', 'edit')->name('users.edit');
        Route::put('/users/{user}', 'update')->name('users.update');
        Route::delete('/users/{user}', 'destroy')->name('users.destroy');
    });

    Route::put('/users/{user}/status', [StatusController::class, 'update'])->name('users.status.update');
    Route::put('/users/{user}/role', [RoleController::class, 'update'])->name('users.role.update');
});

require __DIR__.'/auth.php';
