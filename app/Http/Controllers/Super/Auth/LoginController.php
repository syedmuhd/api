<?php

namespace App\Http\Controllers\Super\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Authentication
 * Login for Super Admin
 */

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $super = User::where([
            'email' => $validated['email'],
            'is_super' => 1
        ])->first();

        // Notify by email login succeed

        $token = $super->createToken('token-super', ['*'])->plainTextToken;

        return response()->json(['token' => $token], Response::HTTP_OK);
    }
}
