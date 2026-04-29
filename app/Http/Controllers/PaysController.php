<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use Illuminate\Http\Request;

class PaysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Pays::select('id_pays', 'pays')->get()
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
        $request->validate([
            'pays' => 'required|string|max:100|unique:pays,pays',
        ]);

        $pays = Pays::create(['pays' => $request->pays]);

        return response()->json($pays, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pays $pays)
    {
        return response()->json($pays);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pays $pays)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pays $pays)
    {
        $request->validate([
            'pays' => 'required|string|max:100|unique:pays,pays,' . $pays->id_pays . ',id_pays',
        ]);

        $pays->update(['pays' => $request->pays]);

        return response()->json($pays);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pays $pays)
    {
        $pays->delete();

        return response()->json(['success' => 'Pays supprimé.']);
    }
}
