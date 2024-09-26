<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Http\Requests\StoreCandidatRequest;
use App\Http\Requests\UpdateCandidatRequest;
use App\Models\Consultant;
use App\Models\offre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

//        $candidats = Candidat::with('offre')->get();
//
        $candidats = Candidat::with(['user', 'offre'])->get();
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
//    public function store(Request $request)
//    {
//        // Validation des données
//        $request->validate([
//            'nom' => 'required|string|max:255',
//            'prenom' => 'required|string|max:255',
//            'email' => 'required|email|unique:candidats,email',
//            'adresse' => 'required|string',
////            'telephone'=>'required|string|max:9',
////            'status' => 'required|string',
//            'date_de_candidature' => 'required|date',
//            'date_de_naissance' => 'required|date',
//            'lm' => 'required|file|mimes:pdf,doc,docx',
//            'cv' => 'required|file|mimes:pdf,doc,docx',
//            'competences' => 'required|string',
//            'experience' => 'required|string',
//            'offre_id' => 'required|exists:offres,id',
//
//        ]);
//
//        // Gestion du fichier CV et LM
//        $cvPath = $request->file('cv')->store('cvs', 'public');
//        $lmPath = $request->file('lm')->store('lms', 'public');
//
//
//
//        // Création du candidat
//        $candidat = Candidat::create([
//            'nom' => $request->nom,
//            'prenom' => $request->prenom,
//            'email' => $request->email,
//            'adresse' => $request->adresse,
//            'status' => 'en_attente',
//            'telephone' => $request->telephone,
//            'date_de_candidature' => now(),
//            'experience' => $request->experience,
//
//            'competences' => $request->competences,
//            'date_de_naissance' => $request->date_de_naissance,
//            'lm' => $lmPath,
//            'cv' => $cvPath,
//            'offre_id' => $request->offre_id,
//        ]);
//
//        return response()->json($candidat, 201);
//
//    }
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            // Validation for the user and candidate fields
            'name' => 'string',
            'email' => 'string|email|max:255|unique:users',
            'telephone' => 'string',
            'adresse' => 'string',
            'date_de_naissance' => 'date',
            'lm' => 'required|file|mimes:pdf,doc,docx',
            'cv' => 'required|file|mimes:pdf,doc,docx',
            'offre_id' => 'exists:offres,id',
        ]);

        // Retrieve the authenticated user
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Store CV and LM files
        $cvPath = $request->file('cv')->store('cvs', 'public');
        $lmPath = $request->file('lm')->store('lms', 'public');

        // Create the candidate and associate the user
        $candidat = Candidat::create([
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'date_de_naissance' => $request->date_de_naissance,
            'cv' => $cvPath,
            'lm' => $lmPath,
            'status' => 'nouveau',  // or other default status
            'date_de_candidature' => now(),
            'offre_id' => $request->offre_id,
            'user_id' => $user->id // Properly include user ID
        ]);

        return response()->json(['success' => true, 'candidat' => $candidat, 'user' => $user]);
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
        // Trouver le candidat par ID
        $candidat = Candidat::findOrFail($id);

        // Vérifier si le candidat est déjà accepté
        if ($candidat->status === 'Accepté') {
            return response()->json(['message' => 'Ce candidat est déjà accepté.'], 400);
        }

        // Mettre à jour le statut du candidat
        $candidat->status = 'Accepté';
        $candidat->save();

        // Convertir le candidat en consultant
        $consultant = new Consultant();
        $consultant->user_id = $candidat->user_id; // ID utilisateur associé
        $consultant->adresse = $candidat->adresse;
        $consultant->telephone = $candidat->telephone;
        $consultant->competences = $candidat->competences;
        $consultant->experiences = $candidat->experience; // Vérifiez que le champ 'experience' est correct
        $consultant->cv = $candidat->cv;
        $consultant->status = 'disponible'; // Statut du consultant
        $consultant->date_disponibilite = now(); // Définir la date de disponibilité
        $consultant->statut_evaluation = 'Évalué';
        $consultant->notes_mission=1;
        $consultant->commentaires='cc';
        $consultant->date_de_naissance=$candidat->date_de_naissance;
        $consultant->save();

        try {
            // Enregistrer le consultant
            $consultant->save();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Échec de l\'ajout du consultant: ' . $e->getMessage()], 500);
        }

        // Supprimer le candidat de la table
        $candidat->delete();

        return response()->json([
            'message' => 'Candidat accepté et converti en consultant',
            'consultant_user_name' => $consultant->user ? $consultant->user->name : 'Utilisateur non associé'
        ], 200);
    }









}
