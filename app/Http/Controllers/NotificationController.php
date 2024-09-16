<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\notification;
use App\Http\Requests\StorenotificationRequest;
use App\Http\Requests\UpdatenotificationRequest;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
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
    public function store(StorenotificationRequest $request)
    {
        $mission = Mission::create($request->all());

        // Créer une notification pour le manager
        Notification::create([
            'user_id' => Auth::id(),
            'message' => 'Une nouvelle mission a été ajoutée. Veuillez vérifier les détails.',
        ]);

        return response()->json($mission, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatenotificationRequest $request, notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(notification $notification)
    {
        //
    }


    public function getUnreadNotifications(Request $request)
    {
        $user = $request->user();
        $notifications = Notification::where('user_id', $user->id)
            ->where('read', false)
            ->get();

        return response()->json($notifications);
    }

    public function markAsRead(Request $request)
    {
        $user = $request->user();
        Notification::where('user_id', $user->id)
            ->update(['read' => true]);

        return response()->json(['message' => 'Notifications marquées comme lues.']);
    }

}
