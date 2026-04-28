<?php

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EcouteController;
use App\Http\Controllers\StatisticController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(PlaylistController::class)->group(function() {
    Route::get('/playlist/{id}', 'show')->name('playlistApi');
    Route::get('/link/{link}', 'playlistLink')->name('playlistLink');
    Route::get('/playlists', 'index')->name('playlistsApi');
});
Route::controller(EcouteController::class)->group(function() {
    Route::get('/ecoute/artiste/{id}','ecouteParArtiste')->name('ecouteParArtisteApi');
    Route::get('/ecoute/chanson/{id}','ecouteParChanson')->name('ecouteParChansonApi');
    Route::get('/ecoute/user/{id}','ecouteUtilisateur')->name('ecouteUtilisateurApi');

});
Route::middleware('auth:sanctum')->controller(EcouteController::class)->group(function() {
    Route::post('/ecoute/{id}','addEcoute')->name('addEcouteApi');
});
Route::middleware('auth:sanctum')->controller(PlaylistController::class)->group(function() {
    Route::get('/mesPlaylists', 'mesPlaylists')->name('mesPlaylistsApi');
    Route::post('/playlist/{id}/generateLink', 'generateLink')->name('generateLinkApi');
    Route::put('/playlist/{id}', 'update')->name('modificationPlaylistApi');
    Route::post('/insertion/playlist', 'store')->name('insertionPlaylistApi');
    Route::post('/copy/playlist/{id}', 'store')->name('copyPlaylistApi');
    Route::get('/mesLikes', 'likePlaylist')->name('likePlaylistApi');
    Route::post('/addToPlaylist/{id}/chanson/{chansonId}', 'addChanson')->name('addChansonApi');
    Route::delete('/removeToPlaylist/{id}/chanson/{chansonId}', 'removeChanson')->name('removeChansonApi');
});

Route::middleware('auth:sanctum')->prefix('statistics')->controller(StatisticController::class)->group(function () {
    // users toute les stats peut passer juste par le user logger dout vien le ?
    Route::get('/user/{id?}', 'userStats')->name('api.statistics.user');

    // artiste toute les stats
    Route::get('/artist/{id?}', 'artistStats')->name('api.statistics.artist');
});

Route::post('/token', [RegisteredUserController::class, 'show'])->name('token');
