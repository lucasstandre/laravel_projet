<?php

namespace App\Http\Controllers;

use App\Models\Chanson;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Genre;
use App\Models\User;

class ChansonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Chanson::with(['album', 'genre']);

        if ($request->has('id_album')){
            $query->where('id_album', $request->id_album);
        }

        if ($request->has('id_genre')){
            $query->where('id_genre', $request->id_genre);
        }

        if ($request->has('id_playlist')){
            $query->whereHas('playlists', function($q) use ($request){ // Jai mit $query a place de query pcq ca em donnait une erreur normal ?
                $q->where('playlists.id_playlist', $request->id_playlist);
            });
        }

        return view('chanson.chansons', [
            'chansons' => $query->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('chanson.create', [
            'albums' => Album::all(),
            'genres' => Genre::all(),
            'artistes' => User::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'duree' => 'required|integer',
            'date_sortie' => 'required|date',
            'fichier' => 'required',
            'id_album' => 'required',
            'id_genre' => 'required',
            'id_artiste' => 'required',
        ]);

        Chanson::create([
            'nom' => $request->nom,
            'duree' => $request->duree,
            'description' => $request->description,
            'date_sortie' => $request->date_sortie,
            'fichier' => $request->fichier,
            'like' => 0,
            'id_album' => $request->id_album,
            'id_genre' => $request->id_genre,
            'id_artiste' => $request->id_artiste,
        ]);

        return redirect()->route('chansons');
    }

    /**
     * Display the specified resource.
     */
    public function show(Chanson $chanson)
    {
        return view('chanson.chanson', [
            'chanson' => $chanson
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chanson $chanson)
    {
        return view('chanson.edit',[
            'chanson' => $chanson,
            'albums' => Album::all(),
            'genres' => Genre::all(),
            'artistes' => User::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chanson $chanson)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'duree' => ['required', 'integer'],
            'description' => ['nullable', 'string'],
            'date_sortie' => ['required', 'date'],
            'fichier' => ['required', 'string'],
            'id_album' => ['required'],
            'id_genre' => ['required'],
            'id_artiste' => ['required'],
        ]);

        $chanson->update($validated);

        return redirect()->route('chanson', $chanson)->with('success', 'Chanson modifiée.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chanson $chanson)
    {
        $chanson->delete();

        return redirect()->route('chansons')->with('success', 'Chanson supprime.');
    }
}
