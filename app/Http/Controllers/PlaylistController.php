<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;


class PlaylistController extends Controller
{
    /**
     * Montre les playlist du user ( pour lapi)
     */
    public function mesPlaylists(): JsonResponse
    {
        //pogne le user
        $user = Auth::user();

        if (!$user) {
            return response()->json(['ERREUR' => 'Unauthorized'], 401);
        }

        $playlists = Playlist::where('id_creator', $user->id)->get();

        return response()->json([
            'user_id' => $user->id,
            'playlists' => $playlists
        ], 200);
    }
        /**
     * Generate a public link for a playlist
     */
    public function generateLink(Request $request, int $idPlaylist): JsonResponse
    {
        //pogne le user
        $user = Auth::user();

        if (!$user) {
            return response()->json(['ERREUR' => 'Unauthorized'], 401);
        }
        // pogne la playlist
        $playlist = Playlist::find($idPlaylist);

        if (!$playlist) {
            return response()->json(['ERREUR' => 'La playlist n\'existe pas.'], 404);
        }

        // check si la playlist aparctien au user
        if ($playlist->id_creator !== $user->id) {
            return response()->json(['ERREUR' => 'Vous n\'êtes pas autorisé à modifier cette playlist.'], 403);
        }

        // si le lien exist on return le lien
        if (!empty($playlist->link)) {
            return response()->json([
                'SUCCES' => 'La playlist a déjà un lien public.',
                'playlist' => $playlist,
                'link' => $playlist->link
            ], 200);
        }
        // on genere un lien
        try {
            //cree un uuid unique de playlist
            $uniqueLink = Str::uuid()->toString();
            // pogne le lien le sacre dans link & save
            $playlist->link = $uniqueLink;
            $playlist->save();
            //retourne le lien
            return response()->json([
                'SUCCES' => 'Le lien public a été généré avec succès.',
                'playlist' => $playlist,
                'link' => $uniqueLink
            ], 200);
        } catch (QueryException $erreur) {
            report($erreur);
            return response()->json(['ERREUR' => 'Erreur lors de la génération du lien.'], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        $query = Playlist::query(); // contructeur de requete pour commencer une query
        // on check si le link est par vide car si il les la playlist nest pas public
        // le <> signifie different de, donc on verifie si le link est pas null ou link est different de vide
        $query->whereNotNull('link')->where('link','<>', '');

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
        if ($request->routeIs('insertionPlaylistApi')) {
            $validation = Validator::make($request->all(), [
                'id_user' => 'required',
                'playlist' => 'required',
                'description' => 'required|max:250'
                ], [
                'id_user.required' => 'Veuillez entrer lle user',
                'playlist.required' => 'Veuillez entrer un nom pour la playlist.',
                'description.required' => 'Veuillez inscrire une description pour la playlist.',
                'description.max' => 'Votre description de la playlist ne peut pas dépasser 250 caractères.'
                ]);
            if ($validation->fails()) {
            // On répond à la requête de Postman en plaçant toutes les erreurs qui ont pu survenir dans
            // un conteneur JSON avec un code HTTP 400.
            return response()->json(['ERREUR' => $validation->errors()], 400);
            }
            $contenuDecode = $validation->validated();
            // Rendu ici, les données ont été validées et décodées dans le tableau associatif $contenuDecode.
            // Il faut alors procéder à l’insertion du produit en BD.
            try {
                Playlist::create([
                    'id_user' => $contenuDecode['id_user'],
                    'playlist' => $contenuDecode['playlist'],
                    'description' => $contenuDecode['description']
                ]);

                return response()->json(['SUCCES' => 'La playlist a été ajouté avec succès.'], 200);
            } catch (QueryException $erreur) {
                report($erreur);
                return response()->json(['ERREUR' => 'La playlist n\'a pas été ajouté.'], 500);
            }
        }
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
        $validation = Validator::make($request->all(), [
        'id_playlist' => 'required',
        'playlist' => 'required',
        'description' => 'required'
        ], [
        'id_playlist.required' => 'L\'ID de la playlist est manquant.',
        'playlist.required' => 'Veuillez entrer le nom de la playlist.',
        'description.required' => 'Veuillez entrer une description.',
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation->errors())->withInput();
        }

        $contenuFormulaire = $validation->validated();

        $playlist = Playlist::find($contenuFormulaire['id_playlist']);
        $playlist->playlist = $contenuFormulaire['playlist'];
        $playlist->description = $contenuFormulaire['description'];

        if ($playlist->save()) {
            session()->flash('succes', 'La modification de la playlist a bien fonctionné.');
        } else {
            session()->flash('erreur', 'La modification de la playlist n\'a pas fonctionné.');
        }

        return redirect()->route('playlists');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Playlist $playlist)
    {
        //
    }
}
