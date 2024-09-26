<?php

namespace App\Http\Controllers;

use App\Models\feedback;
use App\Http\Requests\StorefeedbackRequest;
use App\Http\Requests\UpdatefeedbackRequest;
use Illuminate\Http\Request; // Ajoutez cette ligne


class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorefeedbackRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatefeedbackRequest $request, feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(feedback $feedback)
    {
        //
    }

    public function soumettreFeedback(Request $request)
    {
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'collaboration' => 'required|string',
            'delais' => 'required|string',
            'commentaire' => 'nullable|string',
            'mission_id' => 'required|exists:missions,id',
            // 'consultant_id' => 'required|exists:consultants,id', // Pas nécessaire
        ]);

        // Ajout de consultant_id avec la valeur NULL
        $validatedData['consultant_id'] = null;

        // Enregistrer le feedback dans la base de données
        Feedback::create($validatedData);

        return response()->json(['message' => 'Feedback soumis avec succès'], 200);
    }

}
