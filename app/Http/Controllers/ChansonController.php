<?php

namespace App\Http\Controllers;

use App\Models\Chanson;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Genre;
use App\Models\User;
use App\Http\Resources\ChansonResource;
use Illuminate\Support\Facades\Validator;

class ChansonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Chanson::with(['album', 'genre']);

        $filters = $request->only([
            'id_album',
            'id_genre',
            'search',
            'min_likes',
            'min_duree',
            'max_duree',
            'id_playlist'
        ]);

        if ($request->has('id_album')){
            $query->where('id_album', $request->id_album);
        }

        if ($request->has('id_genre')){
            $query->where('id_genre', $request->id_genre);
        }
        // Autre filtres
        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('min_likes')) {
            $query->where('like', '>=', $request->min_likes);
        }



        // Filtre pour le temp min et max
        if ($request->filled('min_duree')) {
            $query->where('duree', '>=', $request->min_duree);
        }

        if ($request->filled('max_duree')) {
            $query->where('duree', '<=', $request->max_duree);
        }


        ////////////Fin filtres/////////////////

        if ($request->has('id_playlist')){
            $query->whereHas('playlists', function($q) use ($request){
                $q->where('playlists.id_playlist', $request->id_playlist);
            });
        }

        if (empty(array_filter($filters))) {
                $query->limit(10);
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
            'genres' => Genre::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'nom' => 'required',
            'duree' => 'required|integer',
            'date_sortie' => 'required|date',
            'fichier' => 'required|file|mimes:mp3',
            'id_genre' => 'required',
        ]);

        if ($validator->fails()) {
            if ($request->routeIs('insertionChansonApi')) {
                return response()->json(['ERREUR' => $validator->errors()], 400);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Gestion du fichier MP3
        $nomFichier = $request->file('fichier')->getClientOriginalName();
        $request->file('fichier')->storeAs('public/chansons', $nomFichier);

        Chanson::create([
            'nom' => $request->nom,
            'duree' => $request->duree,
            'description' => $request->description,
            'date_sortie' => $request->date_sortie,
            'fichier' => $nomFichier,
            'like' => 0,
            'id_genre' => $request->id_genre,
            'id_artiste' => auth()->id(),
            'id_album' => $request->id_album,
        ]);

        //Si le programme veux une reponse Json
        if ($request->expectsJson() || $request->routeIs('insertionChansonApi')) {
            return response()->json([
                'message' => 'Chanson créée avec succès.',
                'nom' => $request->nom,
                'duree' => $request->duree,
                'description' => $request->description,
                'date_sortie' => $request->date_sortie,
                'fichier' => $nomFichier,
                'like' => 0,
                'id_genre' => $request->id_genre,
                'id_artiste' => auth()->id(),
                'id_album' => $request->id_album,
            ], 201);
        }

        return redirect()->route('chansons');

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Chanson $chanson)
    {
        if (request()->expectsJson()) {
            return new ChansonResource($chanson);
        }

        return view('chanson.chanson', [
            'chanson' => $chanson,
            'albums' => Album::all(),
            'genres' => Genre::all(),
            'artistes' => User::all(),
        ]);

        /*return view('chanson.chanson', [
            'chanson' => $chanson,
            'albums' => Album::all(),
            'genres' => Genre::all(),
            'artistes' => User::all(),
        ]);*/
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Chanson $chanson)
    {
        $user = auth()->user();
        // Vu qu'on as pas de colonnes pour savoir qui est lauteur d'une chanson, on vas chercher l'artiste de la premiere chanson

        // Si l'utilisateur n'est pas un admin ou l'auteur, abort

        if($user->role != 1 && $user->id != $chanson->id_artiste){
            if ($request->expectsJson()) {
                return response()->json(['error' => "Acces refuse."], 403);
            }
            return redirect()->route('chansons')
                ->with('error', "Vous n'avez pas le droit de modifier cette chanson.");
        }

        return view('chanson.chanson',[
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
        $user = auth()->user();
        // Vu qu'on as pas de colonnes pour savoir qui est lauteur d'une chanson, on vas chercher l'artiste de la premiere chanson

        // Si l'utilisateur n'est pas un admin ou l'auteur, retourne a la page principale avec un message
        if($user->role != 1 && $user->id != $chanson->id_artiste){
            if ($request->expectsJson()) {
                return response()->json(['error' => "Acces refuse."], 403);
            }
            return redirect()->route('chansons')
                ->with('error', "Vous n'avez pas le droit de modifier cette chanson.");
        }

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

        if ($request->expectsJson()) {
                return response()->json(["Changement fait"], 200);
        }
        return redirect()->route('chanson', $chanson)->with('success', 'Chanson modifiée.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chanson $chanson)
    {
        $user = auth()->user();
        // Vu qu'on as pas de colonnes pour savoir qui est lauteur d'une chanson, on vas chercher l'artiste de la premiere chanson

        // Si l'utilisateur n'est pas un admin ou l'auteur, abort
        if($user->role != 1 && $user->id != $chanson->id_artiste){
            if ($request->expectsJson()) {
                return response()->json(['error' => "Acces refuse."], 403);
            }
            return redirect()->route('chansons')
                ->with('error', "Vous n'avez pas le droit de modifier cette chanson.");
        }

        $chanson->delete();

        return redirect()->route('chansons');
    }

    public function retirerAlbum(Chanson $chanson)
    {
        $chanson->update(['id_album' => null]);
        return back();
    }
}
