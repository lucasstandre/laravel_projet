<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
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
    public function show(Statistic $statistic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Statistic $statistic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Statistic $statistic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Statistic $statistic)
    {
        //
    }

    /**
     * montre le show pour le user
     */
    public function showUser(?int $id = null)
    {
        $user = Auth::user();
        if ($id // si jai un id
        && $id != $user->id // et que lid nest pas le id du user
        && $user->role != 1) { // et que lid nest pas admin
            abort(403, 'Accès non autorisé.'); // marche pas
        }

        $statsResponse = $this->userStats($id);

        if ($statsResponse->status() !== 200) {
            return abort(401);
        }

        return view('statistic.user', $statsResponse->getData(true));
    }

    /**
     * montre les stats en show de lartist
     */
    public function showArtist(?int $id = null)
    {
        $user = Auth::user(); // meme chose que user
        if ($id && $id != $user->id && $user->role != 1) {
            abort(403, 'Accès non autorisé.');
        }

        $statsResponse = $this->artistStats($id);
        if ($statsResponse->status() !== 200) return abort(401);

        return view('statistic.artist', $statsResponse->getData(true));
    }

    /**
     * Retourne les statistiques du user en json
     */
    public function userStats(?int $id = null): JsonResponse
    {
        // si ya pas de id specifier auth toi
        if ($id) {
            $userId = $id;
        } else {
            $userId = Auth::id();
        }

        if (!$userId) {
            return response()->json(['ERREUR' => 'Unauthorized'], 401);
        }

        $user = DB::table('users')->where('id', $userId)->first();

        $userName = $user->name;
        // par default yer pas verifier pi si ya un email verified (on a pas encore un champ verified dans user)
        $isVerified = false;
        if ($user->email_verified_at != null) {
            $isVerified = true;
        }

        $accountAge = round(now()->diffInDays(\Carbon\Carbon::parse($user->created_at)) / 365.25, 1);
        // par default public mais private si on specifie le statu a 0
        $userStatus = 'Public';
        if ($user->status != 0) {
            $userStatus = 'Private';
        }
        //compte les playlist avec count
        $playlistCount = DB::table('playlists')->where('id_creator', $userId)->count();
        //grace a la table dasso on peu voire le TA de toute les playlist des user
        $librarySize = DB::table('ta_playlist_chanson')
            ->join('playlists', 'ta_playlist_chanson.id_playlist', '=', 'playlists.id_playlist')
            ->where('playlists.id_creator', $userId)
            ->distinct('ta_playlist_chanson.id_chanson')
            ->count('ta_playlist_chanson.id_chanson');
        // jai changer pour duree pcq timestamp cest comme une variable par default de laravel
        $listeningTime30Days = (int) DB::table('ecoutes')
            ->where('id_utilisateur', $userId)
            ->where('timestamp', '>=', date('Y-m-d H:i:s', strtotime('-30 days')))
            ->sum('duree') / 60;

        $listeningTimeYear = (int) DB::table('ecoutes')
            ->where('id_utilisateur', $userId)
            ->where('timestamp', '>=', date('Y-01-01 00:00:00'))
            ->sum('duree') /60;

        $totalListens = DB::table('ecoutes')->where('id_utilisateur', $userId)->count();

        $genresData = DB::table('ecoutes')
            ->join('chansons', 'ecoutes.id_chanson', '=', 'chansons.id_chanson')
            ->join('genres', 'chansons.id_genre', '=', 'genres.id_genre')
            ->select('genres.genre', DB::raw('count(*) as listen_count'))
            ->where('ecoutes.id_utilisateur', $userId)
            ->groupBy('genres.id_genre', 'genres.genre')
            ->orderByDesc('listen_count')
            ->get();

        $genres = [];
        foreach ($genresData as $row) {
            $percentage = 0;
            if ($totalListens > 0) {
                $percentage = round(($row->listen_count / $totalListens) * 100, 2);
            }
            $genres[] = [
                'genre' => $row->genre,
                'percentage' => $percentage
            ];
        }
        //pogne les 5 top artiste, count as listen_count apres pogne le top 5
        $topArtistsData = DB::table('ecoutes')
            ->join('chansons', 'ecoutes.id_chanson', '=', 'chansons.id_chanson')
            ->join('users', 'chansons.id_artiste', '=', 'users.id')
            ->select('users.name as artist_name', DB::raw('count(*) as listen_count'))
            ->where('ecoutes.id_utilisateur', $userId)
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('listen_count')
            ->limit(5)
            ->get();

        $topArtists = [];
        foreach ($topArtistsData as $row) {
            $topArtists[] = ['artist_name' => $row->artist_name];
        }

        return response()->json([
            'userName' => $userName,
            'isVerified' => $isVerified,
            'accountAge' => $accountAge,
            'userStatus' => $userStatus,
            'playlistCount' => $playlistCount,
            'librarySize' => $librarySize,
            'listeningTime30Days' => $listeningTime30Days,
            'listeningTimeYear' => $listeningTimeYear,
            'genres' => $genres,
            'topArtists' => $topArtists
        ], 200);
    }

    /**
     * Retourne les statistiques de l'artiste en json
     */
    public function artistStats(?int $id = null): JsonResponse
    {
        $artistId = $id ?: Auth::id();

        $artist = DB::table('users')->where('id', $artistId)->first();
        $artistName = $artist->name;
        $isVerifiedArtist = $artist->email_verified_at != null;

        // total des stream
        $totalStreams = DB::table('ecoutes')
            ->join('chansons', 'ecoutes.id_chanson', '=', 'chansons.id_chanson')
            ->where('chansons.id_artiste', $artistId)
            ->count();

        // 30 jour
        $activeListeners = DB::table('ecoutes')
            ->join('chansons', 'ecoutes.id_chanson', '=', 'chansons.id_chanson')
            ->where('chansons.id_artiste', $artistId)
            ->where('ecoutes.timestamp', '>=', now()->subDays(30))
            ->distinct('ecoutes.id_utilisateur')
            ->count('ecoutes.id_utilisateur');

        // pogne les pays
        $mapData  = DB::table('ecoutes')
            ->join('chansons', 'ecoutes.id_chanson', '=', 'chansons.id_chanson')
            ->join('users', 'ecoutes.id_utilisateur', '=', 'users.id')
            ->join('countries', 'users.id_country', '=', 'countries.id_country')
            ->select('countries.name_country', DB::raw('count(*) as count')) // force un count
            ->where('chansons.id_artiste', $artistId)
            ->groupBy('countries.id_country', 'countries.name_country')
            ->orderByDesc('count')
            ->get();

        // le premier pays de la list devient le topcountry
        $topCountry = $mapData ->first()->name_country ?? 'None';



        $trends = DB::table('ecoutes')
            ->join('chansons', 'ecoutes.id_chanson', '=', 'chansons.id_chanson')
            ->select(DB::raw('DATE(timestamp) as date'), DB::raw('count(*) as streams'))
            ->where('chansons.id_artiste', $artistId)
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();


        $playlistAdds = DB::table('ta_playlist_chanson')
            ->join('chansons', 'ta_playlist_chanson.id_chanson', '=', 'chansons.id_chanson')
            ->where('chansons.id_artiste', $artistId)
            ->count();
        // pogne le rank de tous
            $allArtists = DB::table('ecoutes')
                ->join('chansons', 'ecoutes.id_chanson', '=', 'chansons.id_chanson')
                ->select('chansons.id_artiste', DB::raw('count(*) as total'))
                ->groupBy('chansons.id_artiste')
                ->orderByDesc('total')
                ->get();

            // variable de base
            $rankPosition = 1;
            $found = false;

            // boucle jusquatemp de trouver lartiste
            foreach ($allArtists as $row) {
                if ($row->id_artiste == $artistId) {
                    $found = true;
                    break;
                }

                $rankPosition++;
            }

            // donc si ta une position on met # devant sinon NR pour not ranked
            if ($found) {
                $globalRank = '#' . $rankPosition;
            } else {
                $globalRank = 'NR';
            }
        return response()->json([
            'artistName' => $artistName,
            'isVerifiedArtist' => $isVerifiedArtist,
            'topCountry' => $topCountry,
            'totalStreams' => $totalStreams,
            'activeListeners' => $activeListeners,
            'monthlyListenersFormatted' => number_format($activeListeners),
            'globalRank' => $globalRank,
            'followerGrowth' => 0, // pour linstant hard coded pcq ya pas de table follower dans user
            'playlistAdds' => $playlistAdds,
            'trends' => $trends,
            'mapData' => $mapData
        ], 200);
    }
}
