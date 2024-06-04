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

class LoginController extends Controller
{
    use ResponseHelper;

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

        if ($emailValidator->valid()) {
            $user = User::where(['email' => $emailValidator->valid()['email']])->first();
        } else if ($phoneValidator->valid()) {
            $user = User::where(['phone' => $phoneValidator->valid()['phone']])->first();
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

        setPermissionsTeamId($user->team_id);

        $user->updateLastLogin();

        return $this->responseOk([
            'accessToken' => $token,
            'userData' => $user->toArray() + ['role' => $user->getRoleNames()[0]],
            'userAbilityRules' => [
                ["action" => "manage", "subject" => "all"],
            ]
        ]);
    }
}
