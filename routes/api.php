<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EcouteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ChansonController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\LocalisationController;
use App\Http\Controllers\GenreController;

Route::prefix('auth')->controller(ApiAuthController::class)->group(function () {
    Route::post('/login', 'login')->name('api.auth.login');
    Route::post('/register', 'register')->name('api.auth.register');
    Route::post('/logout', 'logout')->middleware('auth:sanctum')->name('api.auth.logout');
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (!auth()->attempt($credentials)) {
        return response()->json(['erreur' => 'Identifiants invalides.'], 401);
    }
    $token = auth()->user()->createToken('api-token')->plainTextToken;
    return response()->json(['token' => $token]);
});

Route::post('/token', [ApiAuthController::class, 'login'])->name('token');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/profile', [ProfileController::class, 'getProfile'])->name('api.profile.show');

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'indexApi')->name('api.users.index');
        Route::get('/users/{user}', 'showApi')->name('api.users.show');
        Route::middleware('admin')->group(function () {
            Route::post('/users', 'storeApi')->name('api.users.store');
            Route::put('/users/{user}', 'updateApi')->name('api.users.update');
            Route::delete('/users/{user}', 'destroyApi')->name('api.users.destroy');
        });
    });

    Route::controller(AlbumController::class)->group(function() {
        Route::post('/insertion/album', 'store')->name('insertionAlbumApi');
        Route::put('/album/{album}', 'update')->name('updateAlbumApi');
        Route::delete('/album/{album}', 'destroy')->name('deleteAlbumApi');
    });

    Route::controller(ChansonController::class)->group(function() {
        Route::post('/insertion/chanson', 'store')->name('insertionChansonApi');
        Route::delete('/chanson/{chanson}', 'destroy')->name('deleteChansonApi');
        Route::put('/chanson/{chanson}', 'update')->name('updateChansonApi');
    });

    Route::controller(PlaylistController::class)->group(function() {
        Route::get('/mesPlaylists', 'mesPlaylists')->name('mesPlaylistsApi');
        Route::post('/playlist/{id}/generateLink', 'generateLink')->name('generateLinkApi');
        Route::put('/playlist/{id}', 'update')->name('modificationPlaylistApi');
        Route::post('/insertion/playlist', 'store')->name('insertionPlaylistApi');
        Route::post('/copy/playlist/{id}', 'store')->name('copyPlaylistApi');
        Route::get('/mesLikes', 'likePlaylist')->name('likePlaylistApi');
        Route::post('/addToPlaylist/{id}/chanson/{chansonId}', 'addChanson')->name('addChansonApi');
        Route::delete('/removeToPlaylist/{id}/chanson/{chansonId}', 'removeChanson')->name('removeChansonApi');
    });

    Route::controller(EcouteController::class)->group(function() {
        Route::post('/ecoute/{id}','addEcoute')->name('addEcouteApi');
        Route::get('/ecoutes/recent', 'lastThreeListens')->name('lastThreeListensApi');
    });

    Route::prefix('statistics')->controller(StatisticController::class)->group(function () {
        Route::get('/user/{id?}', 'userStats')->name('api.statistics.user');
        Route::get('/artist/{id?}', 'artistStats')->name('api.statistics.artist');
    });
});

Route::controller(AlbumController::class)->group(function() {
    Route::get('/albums', 'index');
    Route::get('/album/{album}', 'show')->name('albumApi');
});

Route::get('/chanson/{chanson}', [ChansonController::class, 'show'])->name('chansonApi');

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

Route::apiResource('genres', GenreController::class);

Route::controller(PaysController::class)->group(function() {
    Route::get('/pays', 'index');
    Route::get('/pays/{pays}', 'show');
    Route::post('/pays', 'store');
    Route::put('/pays/{pays}', 'update');
    Route::delete('/pays/{pays}', 'destroy');
});

Route::controller(LocalisationController::class)->group(function() {
    Route::get('/localisations', 'index');
    Route::get('/localisations/{localisation}', 'show');
    Route::post('/localisations', 'store');
    Route::put('/localisations/{localisation}', 'update');
    Route::delete('/localisations/{localisation}', 'destroy');
});
