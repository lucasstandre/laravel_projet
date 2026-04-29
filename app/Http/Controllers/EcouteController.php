<?php

namespace App\Http\Controllers;

use App\Models\Ecoute;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Models\Chanson;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
class EcouteController extends Controller
{
        /**
         * 3 derniere ecoute
         */
        public function lastThreeListens(): JsonResponse
        {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['ERREUR' => 'Utilisateur non connecté'], 401);
            }

            // 3 derniere toune
            $ecoutes = Ecoute::with('chanson')
                ->where('id_utilisateur', $user->id)
                ->orderByDesc('timestamp')
                ->limit(3)
                ->get();

            $historique = [];
            foreach ($ecoutes as $ecoute) {
                $historique[] = [
                    'ecoute_id' => $ecoute->id_ecoute,
                    'chanson' => $ecoute->chanson,
                    'duree' => $ecoute->duree,
                    'timestamp' => $ecoute->timestamp
                ];
            }

            return response()->json([
                'user_name' => $user->name,
                'recent_listens' => $historique
            ], 200);
        }
    /**
     * Ajoute une ecoute a un user
     */
    public function addEcoute(int $idChanson): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['ERREUR' => 'User introuvable'], 404);
        }
        $chanson = Chanson::find($idChanson);

        if (!$chanson) {
            return response()->json(['ERREUR' => 'Chanson introuvable'], 404);
        }

        try {
            Ecoute::create([
                'duree' => '1',
                'timestamp' => now(),
                'id_utilisateur' => $user->id,
                'id_chanson' =>   $chanson->id_chanson,
            ]);
            return response()->json(['SUCCES' => 'La chanson '.$chanson->nom . ' a ete ecouter par le user ' .$user->name],200);
            } catch (QueryException $erreur) {
                report($erreur); // checker le message derruer car le link na pas de default ?
                return response()->json(['ERREUR' => 'Lecoute na pas ete enregistrer', 'details' => $erreur->getMessage()], 500);
            }

    }

    /**
     * Renvoie les ecoutes par chanson
     */
    public function ecouteParChanson(int $idChanson): JsonResponse
    {
        $chanson = Chanson::find($idChanson);

        if (!$chanson) {
            return response()->json(['ERREUR' => 'Chanson introuvable'], 404);
        }

        $totalEcoutes = Ecoute::where('id_chanson', $idChanson)->count();

        return response()->json([
            'chanson' => $chanson->nom,
            'total' => $totalEcoutes,
        ], 200);
    }

    /**
     * Renvoie les ecoutes par artiste
     */
    public function ecouteParArtiste(int $idArtiste): JsonResponse
    {
        $artiste = User::find($idArtiste);

        if (!$artiste) {
            return response()->json(['ERREUR' => 'Artiste introuvable'], 404);
        }
        $chansons = Chanson::where('id_artiste', $artiste->id)->get();
        $totalEcoutes = 0;
        foreach($chansons as $chanson){
            $totalEcoutes += Ecoute::where('id_chanson', $chanson->id_chanson)->count();
        }

        return response()->json([
            'artiste' => $artiste->name,
            'total' => $totalEcoutes
        ], 200);
    }


    /**
     * Renvoie les ecoutes selon l'utilisateur
     */
    public function ecouteUtilisateur(int $idUser) : JsonResponse
    {
        //pogne le user
        $user = User::find($idUser);

        if (!$user) {
            return response()->json(['ERREUR' => 'Unauthorized'], 401);
        }

        // pogne toute les chansons ecouter par le user
        $ecoutes = Ecoute::with('chanson')->where('id_utilisateur', $user->id)->get();

        $historique = [];
        foreach ($ecoutes as $ecoute) {
            $historique[] = [
                'ecoute_id' => $ecoute->id_ecoute,
                'chanson' => $ecoute->chanson,
                'duree' => $ecoute->duree,
                'timestamp' => $ecoute->timestamp
            ];
        }

        return response()->json([
            'user_id' => $user->id,
            'historique' => $historique
        ], 200);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Ecoute $ecoute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ecoute $ecoute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ecoute $ecoute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ecoute $ecoute)
    {
        //
    }
}
