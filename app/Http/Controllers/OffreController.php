<?php

namespace App\Http\Controllers;

use App\Models\offre;
use App\Http\Requests\StoreoffreRequest;
use App\Http\Requests\UpdateoffreRequest;
use http\Env\Response;
use Illuminate\Http\Request;


class OffreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offres = Offre::with('client')->get();

        return response()->json($offres);

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
        $validatedData = $request->validate([
            'titre' => 'required',
            'description' => 'required',
            'competences' => 'required',
            'experience' => 'required|integer',
            'lieu' => 'required',
            'type_contrat' => 'required',
            'date_debut' => 'required|date',
            'client_id' => 'required|exists:clients,id',
        ]);

        $offre = Offre::create($validatedData);

        return response()->json([
            'message' => 'Offre créée avec succès',
            'offre' => $offre
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $offre = Offre::find($id);

        if ($offre) {
            return response()->json($offre);
        } else {
            return response()->json(['message' => 'Offre non trouvée'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(offre $offre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateoffreRequest $request, offre $offre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(offre $offre)
    {
        //
    }

    public function filtrage(Request $request)
    {
        $query = Offre::with('client');

        // Filtering by location (lieu)
        if ($request->has('lieu')) {
            $query->where('lieu', 'LIKE', '%' . $request->lieu . '%');
        }

        // Filtering by experience
        if ($request->has('experience')) {
            $query->where('experience', '>=', $request->experience);
        }

        // Filtering by type of contract
        if ($request->has('type_contrat')) {
            $query->where('type_contrat', $request->type_contrat);
        }

        // Add more filters if needed...

        // Execute the query and get the results
        $offres = $query->get();

        return response()->json($offres);
    }

}
