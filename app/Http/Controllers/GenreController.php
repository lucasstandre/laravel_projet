<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    /**
     * Liste tous les genres
     */
    public function index()
    {
        $genres = Genre::all();
        return response()->json($genres, 200);
    }

    /**
     * Créer un nouveau genre
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'genre' => 'required|string|max:50|unique:genres,genre',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $genre = Genre::create($request->all());
        return response()->json($genre, 201);
    }

    /**
     * Afficher un genre spécifique
     */
    public function show($id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Genre non trouvé'], 404);
        }

        return response()->json($genre, 200);
    }

    /**
     * Mettre à jour un genre
     */
    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Genre non trouvé'], 404);
        }

        $genre->update($request->all());
        return response()->json($genre, 200);
    }

    /**
     * Supprimer un genre
     */
    public function destroy($id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json(['message' => 'Genre non trouvé'], 404);
        }

        $genre->delete();
        return response()->json(['message' => 'Genre supprimé avec succès'], 200);
    }
}
