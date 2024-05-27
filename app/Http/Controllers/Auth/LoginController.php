<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\RoleHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

/**
 * Authentication
 * Login for Admin, Staff, Parent, Student
 */

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $user = User::where([
            'email' => $validated['email'],
            'is_super' => 0
        ])->first();

        // Not found
        abort_if(!$user, Response::HTTP_UNAUTHORIZED, 'Invalid credentials');

        // Password not match
        abort_if(!Hash::check($validated['password'], $user['password']), Response::HTTP_UNAUTHORIZED, 'Invalid password');

        // If user is Admin, check how many branch
        // return $user->branches[0]->id;

        setPermissionsTeamId($user->branches[0]->id);

        // Depending on roles, set the abilities on the access token

        $token = null;

        if ($user->hasRole(RoleHelper::ROLE_ADMIN)) {
            $token = $user->createToken('token-admin', [RoleHelper::ROLE_ADMIN])->plainTextToken;
        } else if ($user->hasRole(RoleHelper::ROLE_STAFF)) {
            $token = $user->createToken('token-staff', [RoleHelper::ROLE_STAFF])->plainTextToken;
        } else if ($user->hasRole(RoleHelper::ROLE_PARENT)) {
            $token = $user->createToken('token-parent', [RoleHelper::ROLE_PARENT])->plainTextToken;
        } else if ($user->hasRole(RoleHelper::ROLE_STUDENT)) {
            $token = $user->createToken('token-student', [RoleHelper::ROLE_STUDENT])->plainTextToken;
        }

        return $token;
    }
}
