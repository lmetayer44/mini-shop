<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;   // important
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Login (POST /api/login)
     */
    public function login(Request $request)
    {
        // 1) Valider les champs reçus
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2) Tenter de générer un token JWT
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // 3) Retourner le token
        return $this->respondWithToken($token);
    }

    /**
     * Logout (POST /api/logout)
     */
    public function logout()
    {
        // Invalider le token
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Rafraîchir le token (GET /api/refresh)
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Méthode utilitaire pour renvoyer le token
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Un endpoint pour récupérer l'user actuel (GET /api/me)
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
}
