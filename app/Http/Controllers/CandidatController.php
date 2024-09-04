<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Http\Requests\StoreCandidatRequest;
use App\Http\Requests\UpdateCandidatRequest;
use Illuminate\Http\Request;

class CandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $candidats = Candidat::all();
        return response()->json($candidats);
    }

//    filtre les candidats
    public function filtreCandidats(Request $request)
    {
        // Initialiser la requête
        $query = Candidat::query();

        // Appliquer les filtres si présents
        if ($request->has('competence')) {
            $query->where('competences', 'like', '%' . $request->input('competence') . '%');
        }

        if ($request->has('experience')) {
            $query->where('experiences_professionnelles', 'like', '%' . $request->input('experience') . '%');
        }

        if ($request->has('disponibilite')) {
            $query->where('disponibilite', $request->input('disponibilite'));
        }

        // Récupérer les candidats filtrés
        $candidats = $query->get();

        return response()->json($candidats);
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
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:candidats,email',
            'adresse' => 'required|string',
//            'telephone'=>'required|string|max:9',
            'status' => 'required|string',
            'date_de_candidature' => 'required|date',
            'date_de_naissance' => 'required|date',
            'lm' => 'required|file|mimes:pdf,doc,docx',
            'cv' => 'required|file|mimes:pdf,doc,docx',
        ]);

        // Gestion du fichier CV et LM
        $cvPath = $request->file('cv')->store('cvs', 'public');
        $lmPath = $request->file('lm')->store('lms', 'public');



        // Création du candidat
        $candidat = Candidat::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'adresse' => $request->adresse,
            'status' => $request->status,
            'telephone' => $request->telephone,
            'date_de_candidature' => now(),

            'date_de_naissance' => $request->date_de_naissance,
            'lm' => $lmPath,
            'cv' => $cvPath,
        ]);

        return response()->json($candidat, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Candidat $candidat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidat $candidat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCandidatRequest $request, Candidat $candidat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidat $candidat)
    {
        //
    }
}
