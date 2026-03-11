<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoginRequest;
use App\Http\Requests\StoreRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function register(StoreRegisterRequest $request)
    {
        $user = User::create($request->validated());
        $token = $user->createToken($request->name);
        Auth::login($user);
        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie.',
            'data' => ['user' => $user, 'token' => $token->plainTextToken]
        ],201);
    }

    public function login(StoreLoginRequest $request)
    {
        $user = User::where('email', $request->validated('email'))->first();
        if (!$user || !Hash::check($request->validated('password'), $user->password)) {
            return response()->json([
                "success" => false,
                "message" => "Identifiants incorrects."

            ]);
        }
        $token = $user->createToken($user->name);
        Auth::login($user);
        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie.',
            'data' => ['user' => $user, 'token' => $token->plainTextToken]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            "success" => true,
            "message" => "Déconnexion réussie."

        ]);
    }
}
