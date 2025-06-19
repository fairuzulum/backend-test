<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log; // <-- 1. TAMBAHKAN IMPORT INI

class AuthController extends Controller
{

    public function login(Request $request)
    {
        try {
            Log::info('INCOMING LOGIN PAYLOAD: ' . $request->getContent());

            $email = Crypt::decryptString($request->input('user_name'));
            $password = Crypt::decryptString($request->input('password'));
        } catch (\Exception $e) {

            Log::error('DECRYPTION FAILED: ' . $e->getMessage());

            return response()->json(['error' => 'Invalid payload format.'], 400);
        }

        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }
}
