<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Http\Requests\StoreCandidatRequest;
use App\Http\Requests\UpdateCandidatRequest;
use App\Models\offre;
use Illuminate\Http\Request;

class CandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $candidats = Candidat::with('offre')->get();
        return response()->json($candidats);
}

//    filtre les candidats
    public function filtrageCandidat(Request $request)
    {

        $query = Candidat::with('candidat');

        if ($request->has('competences')) {
            $query->where('competences', 'LIKE', "%. $request->competences .%");
        }

        if ($request->has('experience')) {
            $query->where('experience', 'LIKE', "%. $request->experience. %");
        }



        $candidats = $query->get();

        return response()->json($candidats);
    }


    // Mettre à jour le statut d'un candidat (accepté ou refusé)

    public function updateStatus($id, Request $request)
    {
        $candidat = Candidat::find($id);

        if (!$candidat) {
            return response()->json(['message' => 'Candidat not found'], 404);
        }

        $status = $request->input('status');
        $candidat->status = $status;
        $candidat->save();

        return response()->json(['message' => 'Status updated successfully']);
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
            'competences' => 'required|string',
            'experience' => 'required|string',
            'offre_id' => 'required|exists:offres,id',

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
            'experience' => $request->experience,

            'competences' => $request->competences,
            'date_de_naissance' => $request->date_de_naissance,
            'lm' => $lmPath,
            'cv' => $cvPath,
            'offre_id' => $request->offre_id,
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
    public function destroy($id)
    {
        $candidat = Candidat::findOrFail($id);
        $candidat->delete();

        return response()->json(['message' => 'Candidat supprimé avec succès'], 200);
    }

    public function accepterCandidat($id)
    {
        $candidat = Candidat::findOrFail($id);

        // Mettre à jour le statut du candidat
        $candidat->status = 'Accepté';
        $candidat->save();

        // Convertir le candidat en consultant
        $consultant = new Consultant();
        $consultant->nom = $candidat->nom;
        $consultant->prenom = $candidat->prenom;
        $consultant->email = $candidat->email;
        $consultant->competences = $candidat->competences;
        $consultant->experience = $candidat->experience;
        $consultant->cv = $candidat->cv;
        $consultant->status='Actif';
        // Autres champs nécessaires pour Consultant
        $consultant->save();



        return response()->json(['message' => 'Candidat accepté et converti en consultant'], 200);
    }


}
