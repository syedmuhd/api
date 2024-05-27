<?php

namespace App\Http\Controllers\Super\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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

        return $super->createToken('token-super', ['*'])->plainTextToken;
    }
}
