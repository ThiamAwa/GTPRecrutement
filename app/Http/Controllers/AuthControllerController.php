<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthControllerController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
            'role_id' => 'required|exists:roles,id'
        ]);
        $role_id = $request->role_id ?? 1;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role_id,

        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token], 201);
    }

    public function logout(Request $request)
    {
        // Assurez-vous que l'utilisateur est authentifié via Sanctum
        if ($request->user()) {
            // Révocation de tous les tokens de l'utilisateur
            $request->user()->tokens()->delete();
            // Déconnexion de l'utilisateur
            return response()->json(['message' => 'Déconnecté avec succès.'], 200);
        }

        return response()->json(['message' => 'Aucun utilisateur authentifié.'], 400);
    }


    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json( ['user' => $user,
                'role' => $user->role->name]);
        }

        $token = $user->createToken('apiToken')->plainTextToken;

        $res = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'role' => $user->role->name
        ];

        return response()->json($res, 200);
    }

    public function getAuthenticatedUser()
    {
        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'role' => $user->role->name
        ]);
    }

    public function getUser(Request $request)
    {
        return $request->user();
    }


}
