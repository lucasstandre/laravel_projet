<?php

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaylistController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::controller(PlaylistController::class)->group(function() {
Route::get('/playlist/{id}', 'show')->name('playlistApi');
Route::post('/insertion/playlist', 'store')->name('insertionPlaylistApi');

});
