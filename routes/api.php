<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ChansonController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\LocalisationController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\GenreController;

// LOGIN
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (!auth()->attempt($credentials)) {
        return response()->json(['erreur' => 'Identifiants invalides.'], 401);
    }

    $token = auth()->user()->createToken('api-token')->plainTextToken;
    return response()->json(['token' => $token]);
});

// USER
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// ===== ALBUMS =====
Route::controller(AlbumController::class)->group(function() {
    Route::get('/albums', 'index');
    Route::get('/album/{album}', 'show')->name('albumApi');
});

Route::middleware('auth:sanctum')->controller(AlbumController::class)->group(function() {
    Route::post('/insertion/album', 'store')->name('insertionAlbumApi');
    Route::put('/album/{album}', 'update')->name('updateAlbumApi');
    Route::delete('/album/{album}', 'destroy')->name('deleteAlbumApi');
});


// ===== CHANSONS =====
Route::controller(ChansonController::class)->group(function() {
    Route::get('/chanson/{chanson}', 'show')->name('chansonApi');
});

Route::middleware('auth:sanctum')->controller(ChansonController::class)->group(function() {
    Route::post('/insertion/chanson', 'store')->name('insertionChansonApi');
    Route::delete('/chanson/{chanson}', 'destroy')->name('deleteChansonApi');
    Route::put('/chanson/{chanson}', 'update')->name('updateChansonApi');
});


// ===== PAYS =====
Route::controller(PaysController::class)->group(function() {
    Route::get('/pays', 'index');
    Route::get('/pays/{pays}', 'show');
    Route::post('/pays', 'store');
    Route::put('/pays/{pays}', 'update');
    Route::delete('/pays/{pays}', 'destroy');
});


// ===== LOCALISATIONS =====
Route::controller(LocalisationController::class)->group(function() {
    Route::get('/localisations', 'index');
    Route::get('/localisations/{localisation}', 'show');
    Route::post('/localisations', 'store');
    Route::put('/localisations/{localisation}', 'update');
    Route::delete('/localisations/{localisation}', 'destroy');
});


// ===== PLAYLISTS =====
Route::controller(PlaylistController::class)->group(function() {
    Route::get('/playlist/{id}', 'show')->name('playlistApi');
    Route::get('/link/{link}', 'playlistLink')->name('playlistLink');
    Route::get('/playlists', 'index')->name('playlistsApi');
});

Route::middleware('auth:sanctum')->controller(PlaylistController::class)->group(function() {
    Route::get('/mesPlaylists', 'mesPlaylists')->name('mesPlaylistsApi');
    Route::post('/playlist/{id}/generateLink', 'generateLink')->name('generateLinkApi');
    Route::put('/playlist/{id}', 'update')->name('modificationPlaylistApi');
    Route::post('/insertion/playlist', 'store')->name('insertionPlaylistApi');
    Route::post('/copy/playlist/{id}', 'store')->name('copyPlaylistApi');
    Route::get('/mesLikes', 'likePlaylist')->name('likePlaylistApi');
});




Route::apiResource('genres', GenreController::class);

// TOKEN
Route::post('/token', [RegisteredUserController::class, 'show'])->name('token');
