<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use App\Http\Requests\StoreConsultantRequest;
use App\Http\Requests\UpdateConsultantRequest;

use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consultants = Consultant::with('user')->get();
        return response()->json($consultants);
    }

//    filtrage consultant

    public function filterConsultant(Request $request) {
        try {
            // Validate input
            $validatedData = $request->validate([
                'competences' => 'nullable|string|max:255',
                'experience' => 'nullable|integer|min:0',
                'date_disponibilite' => 'nullable|date',
            ]);

            // Start building the query
            $query = Consultant::query();

            // Filter by competences if provided
            if (!empty($validatedData['competences'])) {
                $query->where('competences', 'like', '%' . $validatedData['competences'] . '%');
            }

            // Filter by experience if provided
            if (!empty($validatedData['experiences'])) {
                $query->where('experiences', '>=', $validatedData['experiences']);
            }

            // Filter by date_disponibilite if provided
            if (!empty($validatedData['date_disponibilite'])) {
                $query->whereDate('date_disponibilite', '<=', $validatedData['date_disponibilite']);
            }

            // Fetch consultants
            $consultants = $query->get();
            Log::info($request->all());

            return response()->json($consultants);

        } catch (\Exception $e) {
            \Log::error("Error fetching consultants: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return response()->json([
                'error' => 'An error occurred while fetching consultants',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
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
    public function store(StoreConsultantRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultant $consultant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consultant $consultant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConsultantRequest $request, Consultant $consultant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultant $consultant)
    {
        //


    }

    public function filtrageCandidat(Request $request)
    {
        $query = Candidat::query();

        if ($request->has('competences')) {
            $competences = explode(',', $request->input('competences'));
            foreach ($competences as $competence) {
                $query->where('competences', 'LIKE', '%' . $competence . '%');
            }
        }

        if ($request->has('experience_min')) {
            $experienceMin = $request->input('experience_min');
            $query->where('experience', '>=', $experienceMin);
        }

        $candidats = $query->get();

        return response()->json($candidats);
    }
}
