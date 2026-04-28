<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\User;
use Illuminate\View\View;
use App\Http\Resources\AlbumResource;
use Illuminate\Support\Facades\Validator;


class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        $query = Album::query();


        if ($request->has('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%'); // ont fait un where playlist like %rock% donc on peut etre au millieu dun mot
        }
        // si le filtre est fait donc on check si yer original (un bool) qui dit si la playlist est fait par le user (example de filtre)
        if ($request->filled('genre')) {
            // fait comme cela vu que genre est dans une differente table
            $query->whereHas('chansons.genre', function ($q) use ($request) {
                $q->where('id_genre', $request->genre);
            });
        }

        $albums = $query->get();
        return view ('album.albums', [
            'albums' => Album::with('chansons.genre', 'chansons.user')->get(),
            'genres' => Genre::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('album.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'photo' => 'nullable',
        ], [
            'nom.required' => 'Veuillez entrer un nom pour l\'album.'
        ]);

        if ($validator->fails()) {
            if ($request->routeIs('insertionAlbumApi')) {
                return response()->json(['ERREUR' => $validator->errors()], 400);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Album::create($validator->validated());

        if ($request->routeIs('insertionAlbumApi')) {
            return response()->json(['success' => 'Album créé.'], 201);
        }

        return redirect()->route('albums');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Album $album)
    {
        // pas besoin de montrer juste une musique sans le edit
        if ($request->routeIs('album')) {
            return redirect()->route('albums.edit', $album);
        }

        return new AlbumResource($album);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Album $album)
    {
        $user = auth()->user();
        // Vu qu'on as pas de colonnes pour savoir qui est lauteur d'un album, on vas chercher l'artiste de la premiere chanson
        $auteur = $album->chansons->first()?->id_artiste;

        // Si l'utilisateur n'est pas un admin ou l'auteur, abort
        if($user->role != 1 && $user->id != $auteur){
            if ($request->expectsJson()) {
                return response()->json(['error' => "Acces refuse."], 403);
            }
            return redirect()->route('albums')
                ->with('error', "Vous n'avez pas le droit de modifier cette album.");
        }

        return view('album.edit', [
            'album' => $album->load('chansons.genre', 'chansons.user'),
            'genres' => Genre::all(),
            'artistes' => User::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    /** Met a jour tous les musiques dans l'album quand le nom de l'artiste est change */
    public function update(Request $request, Album $album)
    {
        $user = auth()->user();
        // Vu qu'on as pas de colonnes pour savoir qui est lauteur d'un album, on vas chercher l'artiste de la premiere chanson
        $auteur = $album->chansons->first()?->id_artiste;

        // Si l'utilisateur n'est pas un admin ou l'auteur, abort
        if($user->role != 1 && $user->id != $auteur){
            if ($request->expectsJson()) {
                return response()->json(['error' => "Acces refuse."], 403);
            }
            return redirect()->route('albums')
                ->with('error', "Vous n'avez pas le droit de modifier cette album.");
        }

        $album->update(['nom' => $request->nom]);

        $album->chansons()->update([
            'id_genre' => $request->id_genre,
            'id_artiste' => $request->id_artiste,
        ]);

        return redirect()->route('albums.edit', $album);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Album $album)
    {
        $user = auth()->user();
        // Vu qu'on as pas de colonnes pour savoir qui est lauteur d'un album, on vas chercher l'artiste de la premiere chanson
        $auteur = $album->chansons->first()?->id_artiste;

        // Si l'utilisateur n'est pas un admin ou l'auteur, abort
        if($user->role != 1 && $user->id != $auteur){
            if ($request->expectsJson()) {
                return response()->json(['error' => "Acces refuse."], 403);
            }
            return redirect()->route('albums')
                ->with('error', "Vous n'avez pas le droit de modifier cette album.");
        }

        $album->chansons()->update(['id_album' => null]);
        $album->delete();
        return redirect()->route('albums');
    }
    public function chansons()
    {
        return $this->hasMany(Chanson::class,'id_album');
    }
}
