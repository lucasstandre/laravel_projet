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
    public function index(Request $request) : View
    {
        $query = Playlist::query(); // contructeur de requete pour commencer une query
        // si ya une request qui est search
        if ($request->has('search')) {
        $query->where('playlist', 'like', '%' . $request->search . '%'); // ont fait un where playlist like %rock% donc on peut etre au millieu dun mot
        }
        // si le filtre est fait donc on check si yer original (un bool) qui dit si la playlist est fait par le user (example de filtre)
        if ($request->filled('original')) {
            $query->where('original', $request->original);
        }

        $playlists = $query->get();

        return view('playlist/playlists', [
        // D’autres paramètres peuvent être passés à la vue en les séparant par une virgule.
        'playlists' => $playlists // retourn toute les playlists apres la requete, par default sa pogne all
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
        $playlist = Playlist::find($idPlaylist);
        if(is_null($playlist))
            return abort(404); //Redirige vers 404 not found
        return view('playlist/playlist', [
            'playlist' => $playlist
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
