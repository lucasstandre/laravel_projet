<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlaylistResource;
use App\Models\Playlist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use App\Http\Resources\ProduitResource;


class PlaylistController extends Controller
{
    /**
     * Pogne la playlist de like
     */
    public function addChanson(int $idPlaylist, int $idChanson) : JsonResponse
    {
        //pogne le user
        $user = Auth::user();

        if (!$user) {
            return response()->json(['ERREUR' => 'Unauthorized'], 401);
        }

        $playlist = Playlist::where('id_creator', $user->id)->where('id_playlist', $idPlaylist)->first();// double query, obliger dituliser first
        if (!$playlist) {
        return response()->json(['ERREUR' => 'Playlist introuvable'], 404);
        }
        try {
        // on add vie attach
        $playlist->chansons()->attach($idChanson, [
            'date_ajout' => now()
        ]);

        return response()->json(['SUCCES' => 'Chanson ajoutée à la playlist'], 200);

    } catch (QueryException $erreur) {
        return response()->json(['ERREUR' => 'L\'ajout a échoué', 'details' => $erreur->getMessage()], 500);
    } // add chanson here

    }
    /**
     * Pogne la playlist de like
     */
    public function likePlaylist() : JsonResponse
    {
        //pogne le user
        $user = Auth::user();

        if (!$user) {
            return response()->json(['ERREUR' => 'Unauthorized'], 401);
        }

        $playlist = Playlist::where('id_creator', $user->id)->where('playlist', 'Liked')->first(); // double query

        return response()->json([
            'user_id' => $user->id,
            'playlist_id' => $playlist->id_playlist,
            'chansons' => $playlist->chansons
        ], 200);
    }
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
    public function index(Request $request)
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

        if ($request->routeIs('playlistsApi') || $request->wantsJson()) {
            return response()->json(['playlists' => $playlists], 200);
        }

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
    public function store(Request $request, $idPlaylist = null)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['ERREUR' => 'Unauthorized'], 401);
        }

        if ($request->routeIs('insertionPlaylistApi')) {
            $validation = Validator::make($request->all(), [
                'playlist' => 'required',
                'description' => 'required|max:250',
                'original' => 'nullable|boolean'
                ], [
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
                    'id_creator' => $user->id, // pogne le id du user
                    'playlist' => $contenuDecode['playlist'],
                    'description' => $contenuDecode['description'],
                    'link' => '',
                    'original' => $contenuDecode['original'] ?? false // si ya rien cest false si cest specifier cest true
                ]);

                return response()->json(['SUCCES' => 'La playlist a été ajouté avec succès.'], 200);
            } catch (QueryException $erreur) {
                report($erreur); // checker le message derruer car le link na pas de default ?
                return response()->json(['ERREUR' => 'La playlist n\'a pas été ajouté.', 'details' => $erreur->getMessage()], 500);
            }
        }
        elseif ($request->routeIs('copyPlaylistApi')) {
            $playlistCopy = Playlist::find($idPlaylist);

            if (!$playlistCopy) {
                return response()->json(['ERREUR' => 'La playlist à copier est introuvable.'], 404);
            }

            try {
                Playlist::create([
                    'id_creator' => $user->id,
                    'playlist' => 'Copie de ' . $playlistCopy->playlist . ' par ' . $playlistCopy->user->name, // pogne le name du createur original
                    'description' => $playlistCopy['description'],
                    'link' =>   '', // si ya pas de link c vide
                    'original' => false // par default false pcq cest pas ta playlist mais celle de
                ]);

                return response()->json(['SUCCES' => 'La playlist a été copier avec succès.'], 200);
            } catch (QueryException $erreur) {
                report($erreur); // checker le message derruer car le link na pas de default ?
                return response()->json(['ERREUR' => 'La playlist n\'a pas été copier.', 'details' => $erreur->getMessage()], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $idPlaylist)
    {
        if ($request->routeIs('playlist')) {
        $playlist = Playlist::find($idPlaylist);
        if(is_null($playlist))
            return abort(404); //Redirige vers 404 not found
        return view('playlist/playlist', [
            'playlist' => $playlist
        ]); // devrait display toute les toune aussi
        }
        // api
        else if ($request->routeIs('playlistApi')) {
        $playlist = Playlist::find($idPlaylist);
        if (empty($playlist))
        return response()->json(['ERREUR' => 'La playlist demandé est introuvable.'], 400);
        return new PlaylistResource($playlist);
        }

    }

    /**
     * Display the specified resource by its public link.
     */
    public function playlistLink(Request $request, string $link)
    {
        $playlist = Playlist::where('link', $link)->first(); // un get marche pas il faut un first pour 1 seul record

        if (empty($playlist)) {
            if ($request->routeIs('playlistLink')) {
                return response()->json(['ERREUR' => 'Le lien de la playlist est invalide.'], 404);
            }
            return abort(404);
        }

        if ($request->routeIs('playlistLinkApi')) {
            return new PlaylistResource($playlist);
        }

        return view('playlist/playlist', [
            'playlist' => $playlist
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id = $request->input('id_playlist');
        $playlist = Playlist::find($id);

        if (is_null($playlist)) {
            return abort(404); // Au cas où le produit n'existerait plus
        }

        return view('playlist/formulairePlaylist', [
            'playlist' => $playlist
        ]);
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
