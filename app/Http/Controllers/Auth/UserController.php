<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ResponseHelper;

    /**
     * Register User
     * Entity: Staff, Parent, Student
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|alpha',
            'email' => 'required_without:phone|email:rfc,dns',
            'phone' => 'required_without:email|numeric|phone:MY',
            'password' => 'required|min:8',
        ]);

        $user = UserService::createUser($validated);

        if ($user) {
            return response()->json(['message' => 'success'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'error'], Response::HTTP_CONFLICT);
        }
    }

    /**
     * Login User
     */

    public function login(Request $request)
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

        if ($emailValidator->valid()) {
            $user = User::where([
                'email' => $emailValidator->valid()['email'],
            ])->first();
        } else if ($phoneValidator->valid()) {
            $user = User::where([
                'phone' => $phoneValidator->valid()['phone'],
            ])->first();
        } else {
            return response()->json(['Invalid phone or email'], Response::HTTP_CONFLICT);
        }

        if (!$user) {
            return response()->json(['Invalid credentails'], Response::HTTP_CONFLICT);
        }

        if (!Hash::check($validated['password'], $user['password'])) {
            return response()->json(['Invalid credentails'], Response::HTTP_CONFLICT);
        }

        $token = $user->createToken('token')->plainTextToken;

        return $this->responseOk([
            'accessToken' => $token,
            'userData' => $user->toArray() + ['role' => 'admin'],
            'userAbilityRules' => [
                ["action" => "manage", "subject" => "all"],
            ]
        ]);
    }
}
