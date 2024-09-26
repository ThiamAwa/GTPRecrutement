<?php

namespace App\Http\Controllers;

use App\Mail\MissionAssignedMail;
use App\Mail\MissionValideeEmail;
use App\Models\Contrat;
use App\Models\Mission;
use App\Mail\MissionAddedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Events\MissionSubmitted;
use App\Models\Consultant;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;




use Illuminate\Http\Request;


class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Charger les missions avec les consultants et les utilisateurs associés
        $missions = Mission::with('consultant.user')->get();

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

    public function getMissionById($id)
    {
        $mission = Mission::find($id);

        if (!$mission) {
            return response()->json(['message' => 'Mission non trouvée'], 404);
        }

        return response()->json($mission);
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
        $validatedData['consultant_id'] = null;
        $validatedData['status'] = 'en_attente'; // Statut initial

        // Créer la mission
        $mission = Mission::create($validatedData);
//        $manager = User::where('role', 'manager')->first();

        // Optionnel : envoyer un e-mail de confirmation
//         Mail::to('thiamawa@groupeisi.com')->send(new MissionAddedMail($mission));
////        if ($manager) {
////            // Envoyer une notification au manager
////            $manager->notify(new NewMissionSubmitted($mission));
////        }
        event(new MissionSubmitted($mission));

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
        \DB::enableQueryLog(); // Enable query logging
        try {
            // Fetch missions with status 'en_cours' and load related consultant and user
            $missions = Mission::with('consultant.user')->where('status', 'en_cours')->get();

            // Log the executed SQL query
            \Log::info('Executed Query: ', \DB::getQueryLog());

            return response()->json($missions);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error fetching ongoing missions: ' . $e->getMessage());

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function gettermineMissions() {
        \DB::enableQueryLog(); // Enable query logging
        try {
            // Fetch missions with status 'en_cours' and load related consultant and user
            $missions = Mission::with('consultant.user')->where('status', 'terminee')->get();

            // Log the executed SQL query
            \Log::info('Executed Query: ', \DB::getQueryLog());

            return response()->json($missions);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error fetching ongoing missions: ' . $e->getMessage());

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
    public function assignConsultant(Request $request, $missionId)
    {
        // Validation des données
        $validatedData = $request->validate([
            'consultant_id' => 'required|exists:consultants,id',
        ]);

        // Récupération de la mission
        $mission = Mission::findOrFail($missionId);

        // Assignation du consultant à la mission
        $mission->consultant_id = $validatedData['consultant_id'];
        $mission->save();

        return response()->json(['message' => 'Mission assignée avec succès']);
    }

    public function sendEmailToConsultant(Request $request)
    {
        $validatedData = $request->validate([
            'consultant_id' => 'exists:consultants,id',
            'mission_id' => 'exists:missions,id',
        ]);

        // Récupération du consultant et de la mission
        $consultant = Consultant::with('user')->findOrFail($validatedData['consultant_id']);
        $mission = Mission::findOrFail($validatedData['mission_id']);

        // Récupération de l'identifiant du client
        $clientId = $mission->client_id;

        // Envoi de l'email
        Mail::to($consultant->user->email)->send(new MissionAssignedMail($mission, $consultant, $clientId));

        return response()->json(['message' => 'Email envoyé avec succès']);
    }






    public function missionsSansConsultant(Request $request)
    {
        $query = Mission::query();

        // Vérifier si le paramètre consultant_id est présent et a une valeur
        if ($request->has('consultant_id') && $request->consultant_id !== '') {
            // Si le paramètre a une valeur, chercher les missions par consultant_id
            $query->where('consultant_id', $request->consultant_id);
        } else {
            // Sinon, récupérer uniquement les missions sans consultant
            $query->whereNull('consultant_id');
        }

        // Exécuter la requête et obtenir les missions
        $missions = $query->get();

        // Retourner les missions sous forme de réponse JSON
        return response()->json($missions);


    }

    public function acceptMission(Request $request)
    {
        $mission_id = $request->query('mission_id');
        $consultant_id = $request->query('consultant_id');

        $mission = Mission::find($mission_id);
        $consultant = Consultant::find($consultant_id);

        if (!$mission || !$consultant) {
            return response()->json(['error' => 'Mission or consultant not found.'], 404);
        }

        // Créer un nouveau contrat
        $contrat = Contrat::create([
            'type_contrat' => 'CDI',
            'statut' => 'en_cours',
            'date_debut' => $mission->date_debut,
            'date_fin' => $mission->date_fin,
            'consultant_id' => $consultant->id,
            'mission_id' => $mission->id,
            'client_id' => $mission->client_id,
        ]);



        // Envoyer une notification au manager
        $manager = $mission->manager;
//        Notification::route('mail', $manager->email)->notify(new ManagerNotified($contrat));

        // Rediriger vers une page de confirmation
        return view('confirmation', ['message' => 'Mission acceptée et contrat créé.']);
    }



    public function rejectMission(Request $request)
    {
        $mission_id = $request->query('mission_id');
        $consultant_id = $request->query('consultant_id');

        $mission = Mission::find($mission_id);
        $consultant = Consultant::find($consultant_id);

        if (!$mission || !$consultant) {
            return response()->json(['error' => 'Mission or consultant not found.'], 404);
        }

        // Mettre à jour le statut de la mission pour indiquer qu'elle a été refusée
        $mission->update(['statut' => 'refusée']);

        // Rediriger vers une page de confirmation
        return view('missions.confirmation', ['message' => 'Mission refusée.']);
    }





    public function updateMissionStatus()
    {
        // Récupérer toutes les missions
        $missions = Mission::all();

        foreach ($missions as $mission) {
            // Convertir la date_debut et date_fin en objets Carbon
            $missionStartDate = Carbon::parse($mission->date_debut);
            $missionEndDate = Carbon::parse($mission->date_fin);

            // Vérifier si la date de début correspond à aujourd'hui
            if ($missionStartDate->isToday() && $mission->consultant_id !== null) {
                // Si la mission commence aujourd'hui, mettre à jour son statut
                $mission->status = 'en_cours';
                $mission->save();
            }

            // Vérifier si la date de fin correspond à aujourd'hui
            if ($missionEndDate->isToday()) {
                // Si la mission se termine aujourd'hui, mettre à jour son statut
                $mission->status = 'terminee';
                $mission->save();
            }
        }

        return response()->json(['message' => 'Statuts mis à jour avec succès.']);
    }


    public function showClientMissionEncours($id)
    {
        try {
            // Trouver la mission par ID et vérifier qu'elle est en cours, avec les informations du consultant et de l'utilisateur
            $mission = Mission::with(['consultant.user']) // Charger les relations consultant et user
            ->where('id', $id)
                ->where('status', 'en_cours')
                ->first();

            // Vérifiez si la mission existe et est en cours
            if (!$mission) {
                return response()->json(['message' => 'Mission non trouvée ou pas en cours'], 404);
            }

            // Si la mission est trouvée, renvoyer les détails de la mission avec les infos du consultant et de l'utilisateur
            return response()->json($mission);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération de la mission', 'exception' => $e->getMessage()], 500);
        }
    }

    public function validerMission($missionId)
    {
        // Trouver la mission
        $mission = Mission::findOrFail($missionId);

        // Vérifier si la mission est terminée avant de la valider
        if ($mission->status !== 'terminee') {
            return response()->json(['error' => 'Mission non terminée'], 400);
        }

        // Récupérer le manager à partir du client lié à la mission
        $manager = $mission->client->user ?? null;  // Assumant que 'client' est lié à 'user'

        // Récupérer le consultant à partir de la mission
        $consultant = $mission->consultant->user ?? null;  // Assumant que 'consultant' est lié à 'user'

        // Vérifier si les emails du manager et du consultant existent
        $managerEmail = $manager ? $manager->email : 'thiamawa@groupeisi.com';  // Email par défaut si pas de manager
        $consultantEmail = $consultant ? $consultant->user->email : 'default.consultant@example.com';  // Email par défaut si pas de consultant

        // Envoyer les emails
        Mail::to($managerEmail)->send(new MissionValideeEmail($mission));
        Mail::to($consultantEmail)->send(new MissionValideeEmail($mission));

        return response()->json(['message' => 'Mission validée et emails envoyés'], 200);
    }
















}
