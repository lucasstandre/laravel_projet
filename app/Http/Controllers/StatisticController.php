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
     * Display the user statistics view.
     */
    public function showUser(?int $id = null)
    {
        // Autorisation : Seulement l'admin peut voir les stats d'un autre utilisateur
        // Note : Ajustez "is_admin" si votre gestion de rôle est différente (ex: ->role === 'admin')
        if ($id && $id != Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Accès non autorisé.');
        }

        $statsResponse = $this->userStats($id);
        if ($statsResponse->status() !== 200) return abort(401);

        return view('statistic.user', $statsResponse->getData(true));
    }

    /**
     * Display the artist statistics view.
     */
    public function showArtist(?int $id = null)
    {
        // Autorisation : Seulement l'admin peut voir les stats d'un autre artiste
        if ($id && $id != Auth::id() && !Auth::user()->is_admin) {
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
        $userId = $id ?? Auth::id();

        if (!$userId) return response()->json(['ERREUR' => 'Unauthorized'], 401);

        $user = DB::table('users')->find($userId);
        $userName = $user->name ?? 'Unknown';
        $isVerified = !is_null($user->email_verified_at);
        $accountAge = round(now()->diffInDays(\Carbon\Carbon::parse($user->created_at)) / 365.25, 1);
        $userStatus = $user->status == 0 ? 'Public' : 'Private';

        // pogne le nombre de playlist du user
        $playlistCount = DB::table('playlists')->where('id_creator', $userId)->count();
        // pogne le nombre de chanson dans les playlist
        $librarySize = DB::table('ta_playlist_chanson')
            ->join('playlists', 'ta_playlist_chanson.id_playlist', '=', 'playlists.id_playlist')
            ->where('playlists.id_creator', $userId)
            ->distinct('ta_playlist_chanson.id_chanson')
            ->count('ta_playlist_chanson.id_chanson');

        // les dates
        $thirtyDaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));
        $startOfYear = date('Y-01-01 00:00:00');

        $listeningTime30Days = (int) DB::table('ecoutes')
            ->where('id_utilisateur', $userId)
            ->where('timestamp', '>=', $thirtyDaysAgo)
            ->sum('duree');

        $listeningTimeYear = (int) DB::table('ecoutes')
            ->where('id_utilisateur', $userId)
            ->where('timestamp', '>=', $startOfYear)
            ->sum('duree');

        // les top des genres
        $totalListens = DB::table('ecoutes')->where('id_utilisateur', $userId)->count();
        $genres = DB::table('ecoutes')
            ->join('chansons', 'ecoutes.id_chanson', '=', 'chansons.id_chanson')
            ->join('genres', 'chansons.id_genre', '=', 'genres.id_genre')
            ->select('genres.genre', DB::raw('count(*) as listen_count'))
            ->where('ecoutes.id_utilisateur', $userId)
            ->groupBy('genres.id_genre', 'genres.genre')
            ->orderByDesc('listen_count')
            ->get();

        foreach ($genres as $genre) {
            $genre->percentage = $totalListens > 0 ? round(($genre->listen_count / $totalListens) * 100, 2) : 0;
        }

        // top artist limit de 5
        $topArtists = DB::table('ecoutes')
            ->join('chansons', 'ecoutes.id_chanson', '=', 'chansons.id_chanson')
            ->join('users', 'chansons.id_artiste', '=', 'users.id')
            ->select('users.name as artist_name', DB::raw('count(*) as listen_count'))
            ->where('ecoutes.id_utilisateur', $userId)
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('listen_count')
            ->limit(5)
            ->get();

        return response()->json(compact(
            'userName', 'isVerified', 'accountAge', 'userStatus', 'playlistCount', 'librarySize', 'listeningTime30Days', 'listeningTimeYear', 'genres', 'topArtists'
        ), 200);
    }

    /**
     * Retourne les statistiques de l'artiste en json
     */
    public function artistStats(?int $id = null): JsonResponse
    {
        $artistId = $id ?? Auth::id();
        if (!$artistId) return response()->json(['ERREUR' => 'Unauthorized'], 401);

        $artist = DB::table('users')->find($artistId);
        $artistName = $artist->name ?? 'Unknown';
        $isVerifiedArtist = !is_null($artist->email_verified_at);
        $topCountry = $artist->country ?? 'Unknown';

        // Calcul du Global Rank
        $allArtistsStreams = DB::table('ecoutes')
            ->join('chansons', 'ecoutes.id_chanson', '=', 'chansons.id_chanson')
            ->select('chansons.id_artiste', DB::raw('count(*) as streams'))
            ->groupBy('chansons.id_artiste')
            ->orderByDesc('streams')
            ->get();
        
        $globalRank = '-';
        foreach ($allArtistsStreams as $index => $row) {
            if ($row->id_artiste == $artistId) {
                $globalRank = '#' . ($index + 1);
                break;
            }
        }

        // Fake data pour Follower Growth vu l'absence de table "followers"
        $followerGrowth = 5200;

        $totalStreams = DB::table('ecoutes')
            ->join('chansons', 'ecoutes.id_chanson', '=', 'chansons.id_chanson')
            ->where('chansons.id_artiste', $artistId)
            ->count();

        $thirtyDaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));

        $activeListeners = DB::table('ecoutes')
            ->join('chansons', 'ecoutes.id_chanson', '=', 'chansons.id_chanson')
            ->where('chansons.id_artiste', $artistId)
            ->where('ecoutes.timestamp', '>=', $thirtyDaysAgo)
            ->distinct('ecoutes.id_utilisateur')
            ->count('ecoutes.id_utilisateur');

        $monthlyListenersFormatted = $activeListeners;
        if ($activeListeners >= 1000000) {
            $monthlyListenersFormatted = round($activeListeners / 1000000, 1) . 'M';
        } elseif ($activeListeners >= 1000) {
            $monthlyListenersFormatted = round($activeListeners / 1000, 1) . 'K';
        }

        $playlistAdds = DB::table('ta_playlist_chanson')
            ->join('chansons', 'ta_playlist_chanson.id_chanson', '=', 'chansons.id_chanson')
            ->where('chansons.id_artiste', $artistId)
            ->count();

        $trends = DB::table('ecoutes')
            ->join('chansons', 'ecoutes.id_chanson', '=', 'chansons.id_chanson')
            ->select(DB::raw('DATE(timestamp) as date'), DB::raw('count(*) as streams'))
            ->where('chansons.id_artiste', $artistId)
            ->where('ecoutes.timestamp', '>=', $thirtyDaysAgo)
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Format trend output manually (no pluck)
        $streamTrends = ['labels' => [], 'data' => []];
        foreach ($trends as $trend) {
            $streamTrends['labels'][] = $trend->date;
            $streamTrends['data'][] = $trend->streams;
        }

        return response()->json(compact('artistName', 'isVerifiedArtist', 'topCountry', 'globalRank', 'monthlyListenersFormatted', 'followerGrowth', 'totalStreams', 'activeListeners', 'playlistAdds', 'streamTrends'), 200);
    }
}
