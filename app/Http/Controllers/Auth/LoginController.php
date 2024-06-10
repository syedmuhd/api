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
        $data = $request->validate([
            'email' => 'required_without:phone',
            'phone' => 'required_without:email',
            'password' => 'required|min:8'
        ]);

        $user = null;

        // Auth by email
        if (isset($data['email'])) {
            $user = User::where(['email' => $data['email']])->first();
        } else if (isset($data['phone'])) {
            $user = User::where(['phone' => $data['phone']])->first();
        } else {
            response()->json(['errors' => ['message' => 'Unknown error']], Response::HTTP_CONFLICT);
        }

        if (!$user) {
            return response()->json(['Invalid credentails'], Response::HTTP_CONFLICT);
        }

        if (!Hash::check($data['password'], $user['password'])) {
            return response()->json(['Invalid credentails'], Response::HTTP_CONFLICT);
        }

        $token = $user->createToken('token')->plainTextToken;

        $user->updateLastLogin();

        $branches = $user->branches;

        return $this->responseOk([
            'accessToken' => $token,
            'userData' => $user->toArray() + ['role' => $user->roles->pluck('name')] + ['branches' => $branches] + ['totalBranches' => count($branches)],
            'userAbilityRules' => [
                ["action" => "manage", "subject" => "all"],
            ]
        ]);
    }
}
