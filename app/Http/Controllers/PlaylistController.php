<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        return view('playlist/playlists', [
        // D’autres paramètres peuvent être passés à la vue en les séparant par une virgule.
        'playlists' => Playlist::All()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $idPlaylist): View
    {
        return view('playlist/playlist', [
            'playlist' => Playlist::find($idPlaylist)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Playlist $playlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Playlist $playlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Playlist $playlist)
    {
        //
    }
}
