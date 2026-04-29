<?php

namespace App\Http\Controllers;

use App\Models\Localisation;
use Illuminate\Http\Request;

class LocalisationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Localisation::select('id_localisation', 'localisation', 'id_pays')->get()
        );
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
        $validator = Validator::make($request->all(), [
            'localisation' => 'required|string|max:32',
            'id_pays' => 'required|exists:pays,id_pays',
        ], [
            'localisation.required' => 'Veuillez entrer un nom de localisation.',
            'id_pays.required' => 'Veuillez entrer un pays.',
            'id_pays.exists' => 'Le pays demandé est introuvable.',
        ]);

        if ($validator->fails()) {
            return response()->json(['ERREUR' => $validator->errors()], 400);
        }

        $localisation = Localisation::create($validator->validated());

        return response()->json($localisation, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Localisation $localisation)
    {
        return response()->json($localisation);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Localisation $localisation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Localisation $localisation)
    {
        $validator = Validator::make($request->all(), [
            'localisation' => 'required|string|max:32',
            'id_pays' => 'required|exists:pays,id_pays',
        ]);

        if ($validator->fails()) {
            return response()->json(['ERREUR' => $validator->errors()], 400);
        }

        $localisation->update($validator->validated());

        return response()->json($localisation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Localisation $localisation)
    {
        $localisation->delete();

        return response()->json(['success' => 'Localisation supprimée.']);
    }
}
