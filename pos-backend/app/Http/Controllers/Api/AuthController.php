<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    // POST /api/auth/login
    public function login(Request $request)
    {
        //If validation fails — Laravel automatically stops here and returns a 422 error response. 
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        //picks only the fields you specify and ignores everything else.
        $credentials = $request->only('email', 'password');

        /* 1. Looks up the user WHERE email = 'john@example.com'
           2. Hashes the given password and compares it to the stored hash
           3. If they match → generates and returns a JWT token
              If they don't match → returns false  */

        // This use auth.php to get the user from db
        if (! $token = Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }

        return $this->tokenResponse($token, Auth::user());
    }

    //builds JSON reply, avoid repeating the same response format in login, register, and refresh.
    private function tokenResponse($token, $user, int $status = 200): JsonResponse
    {
        return response()->json([
            'success'      => true,
            'access_token' => $token,           // The JWT string
            'token_type'   => 'bearer',         // Standard name for JWT auth type
            'expires_in'   => Auth::factory()->getTTL() * 60*6, // Expiry in seconds
            'user'         => $user,            // The logged-in user data
        ], $status);
    }

    // POST /api/auth/logout
    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully!',
        ]);
    }
}
