<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\RoleHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Authentication
 * Login for Admin, Staff, Parent, Student
 */

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'emailOrPhone' => 'required',
            'password' => 'required|min:8'
        ]);

        $user = null;

        $emailValidator = Validator::make(['email' => $validated['emailOrPhone']], [
            'email' => 'email:rfc,dns',
        ]);

        $phoneValidator = Validator::make(['phone' => $validated['emailOrPhone']], [
            'phone' => 'numeric|phone:MY'
        ]);

        // Get user by email
        if ($emailValidator->valid()) {
            $user = User::where([
                'email' => $emailValidator->valid()['email'],
                'is_super' => 0
            ])->first();
        } else if ($phoneValidator->valid()) {
            // Get user by phone
            $user = User::where([
                'phone' => $phoneValidator->valid()['phone'],
                'is_super' => 0
            ])->first();
        } else {
            // Invalid
            abort(Response::HTTP_CONFLICT, "Invalid phone or email");
        }

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

        return response()->json(['token' => $token], Response::HTTP_OK);
    }
}
