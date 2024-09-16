<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Mail\MissionAddedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;


class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $missions = Mission::all();
        return response()->json($missions);
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
        // Valider les données du formulaire
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'status' => 'required|string',
            'type_profil_recherche' => 'required|string',
            'competences_requises' => 'required|array',
            'niveau_experience' => 'required|string',
            'duree' => 'required|integer',
            'objectifs' => 'required|string',
            'client_id' => 'required|exists:clients,id',
            'consultant_id' => 'nullable|exists:consultants,id'
        ]);

        // Créer une nouvelle mission
        Mission::create($validated);

        // Rediriger ou afficher un message de succès
        return redirect()->route('missions.index')->with('success', 'Mission créée avec succès.');
    }


    public function soumettreBesion(Request $request)
    {
        // Vérifie que l'utilisateur est bien authentifié
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Validation des données
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'type_profil_recherche' => 'required|string',
            'competences_requises' => 'required|string',
            'niveau_experience' => 'required|string',
            'duree' => 'nullable|integer',
            'objectifs' => 'required|string',
        ]);

        // Associe l'utilisateur actuel à la mission
        $validatedData['client_id'] = $user->id;
        $validatedData['consultant_id'] = 1;
        $validatedData['status'] = 'en_attente'; // Statut initial

        // Créer la mission
        $mission = Mission::create($validatedData);
        $manager = User::where('role', 'manager')->first();

        // Optionnel : envoyer un e-mail de confirmation
        // Mail::to('thiamawa@groupeisi.com')->send(new MissionAddedMail($mission));
        if ($manager) {
            // Envoyer une notification au manager
            $manager->notify(new NewMissionSubmitted($mission));
        }

        return response()->json($mission, 201); // Retourne la mission créée avec succès
    }

    public function overview()
    {
        $user = Auth::user();
        $missionsEnCours = Mission::where('client_id', $user->id)
            ->where('status', 'en_cours')
            ->get();
        $demandesRecientes = Mission::where('client_id', $user->id)
            ->where('status', '!=', 'terminée')
            ->get();
        $missionsTerminees = Mission::where('client_id', $user->id)
            ->where('status', 'terminée')
            ->get();

        return response()->json([
            'missionsEnCours' => $missionsEnCours,
            'demandesRecientes' => $demandesRecientes,
            'missionsTerminees' => $missionsTerminees,
        ]);
    }



    /**
     * Display the specified resource.
     */

        public function show($id)
    {
        $mission = Mission::findOrFail($id);
        return response()->json($mission);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mission $mission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'titre' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'date_debut' => 'sometimes|date',
            'date_fin' => 'sometimes|date',
            'status' => 'sometimes|in:en_attente,en_cours,terminee',
            'client_id' => 'sometimes|exists:clients,id',
            'consultant_id' => 'nullable|exists:consultants,id',
        ]);

        $mission = Mission::findOrFail($id);
        $mission->update($validatedData);

        return response()->json($mission, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Mission::destroy($id);

        return response()->json(null, 204);
    }

    // app/Http/Controllers/MissionController.php
    // app/Http/Controllers/MissionController.php
    public function updateStatus(Request $request, $id)
    {
        $mission = Mission::find($id);

        if (!$mission) {
            return response()->json(['message' => 'Mission not found'], 404);
        }

        $status = $request->input('status');

        // Définir les statuts valides selon la migration
        $validStatuses = ['en_attente', 'en_cours', 'terminee'];

        if (!in_array($status, $validStatuses)) {
            return response()->json(['errors' => ['status' => ['The selected status is invalid.']]], 422);
        }

        $mission->status = $status;
        $mission->save();

        return response()->json($mission);
    }


    public function getOngoingMissions() {
        try {
            $missions = Mission::where('status', 'en_cours')->get();
            dd(\DB::getQueryLog());
            return response()->json($missions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function getMissionDetails($id)
    {
        $mission = Mission::find($id);
        if ($mission) {
            return response()->json($mission);
        }
        return response()->json(['message' => 'Mission not found'], 404);
    }

    // MissionController.php

    public function getMissionStatistics()
    {
        try {
            // Count missions for each status
            $pendingMissions = Mission::where('status', 'en_attente')->count();
            $ongoingMissions = Mission::where('status', 'en_cours')->count();
            $completedMissions = Mission::where('status', 'terminee')->count();

            // Return the statistics as JSON
            return response()->json([
                'en_attente' => $pendingMissions,
                'en_cours' => $ongoingMissions,
                'terminee' => $completedMissions
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching mission statistics'], 500);
        }
    }

    public function consulterMission($clientId)
    {
        try {
            $missions = Mission::with('consultant')
            ->where('client_id', $clientId)
                ->whereIn('status', ['en_cours','terminee'])
                ->get();
            return response()->json($missions);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération des missions'], 500);
        }
    }



    // Récupérer les détails d'une mission spécifique
    public function showClient($id)
    {
        $user = auth()->user();
        $mission = Mission::where('client_id', $user->id)
            ->where('id', $id)
            ->first();
        if ($mission) {
            return response()->json($mission);
        } else {
            return response()->json(['message' => 'Mission not found'], 404);
        }
    }
    public function getMissionsSansConsultant()
    {
        try {
            // Sélectionne les missions où consultant_id est égal à 0
            $missions = Mission::where('status', 'en_attente')->get();
            return response()->json($missions);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des missions sans consultant : ' . $e->getMessage());
            return response()->json(['error' => 'Une erreur est survenue'], 500);
        }
    }




}
