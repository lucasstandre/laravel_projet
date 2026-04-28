<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::controller(AlbumController::class)->group(function() {
    Route::get('/album/{album}', 'show')->name('albumApi');
    Route::post('/insertion/album', 'store')->name('insertionAlbumApi');
});

// Albums
Route::controller(AlbumController::class)->group(function() {
    Route::get('/album/{album}', 'show')->name('albumApi'); // Public
});

Route::middleware('auth:sanctum')->controller(AlbumController::class)->group(function() {
    Route::post('/insertion/album', 'store')->name('insertionAlbumApi'); // Privé
});

// CHANSONS
Route::controller(ChansonController::class)->group(function() {
    Route::get('/chanson/{chanson}', 'show')->name('chansonApi'); // Public

    Route::post('/insertion/chanson', 'store')->name('insertionChansonApi');
});

Route::middleware('auth:sanctum')->controller(ChansonController::class)->group(function() {

    Route::delete('/chanson/{chanson}', 'destroy')->name('deleteChansonApi');
    Route::put('/chanson/{chanson}', 'update')->name('updateChansonApi');
});

// Pays
Route::controller(PaysController::class)->group(function() {
    Route::get('/pays', 'index');
    Route::get('/pays/{pays}', 'show');
    Route::post('/pays', 'store');
    Route::put('/pays/{pays}', 'update');
    Route::delete('/pays/{pays}', 'destroy');
});

// Localisations
Route::controller(LocalisationController::class)->group(function() {
    Route::get('/localisations', 'index');
    Route::get('/localisations/{localisation}', 'show');
    Route::post('/localisations', 'store');
    Route::put('/localisations/{localisation}', 'update');
    Route::delete('/localisations/{localisation}', 'destroy');
});
?>
