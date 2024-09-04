<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use App\Http\Requests\StoreConsultantRequest;
use App\Http\Requests\UpdateConsultantRequest;

class ConsultantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consultants = Consultant::all();
        return response()->json($consultants);
    }

//    filtrage consultant

    public function filtreConsultants(Request $request)
    {
        $query = Consultant::query();

        // Appliquer les filtres
        if ($request->has('competence')) {
            $query->where('competences', 'like', '%' . $request->input('competence') . '%');
        }

        if ($request->has('experience')) {
            $query->where('experiences_professionnelles', 'like', '%' . $request->input('experience') . '%');
        }

        if ($request->has('disponibilite')) {
            $query->where('status', $request->input('disponibilite'));
        }

        // Récupérer les consultants filtrés
        $consultants = $query->get();

        return response()->json($consultants);
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
}
