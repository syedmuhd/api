<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\RoleHelper;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * Register Staff
 */

class RegisterStaffController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'branch_id' => 'required|integer',
        ]);

        DB::transaction(function () use ($validated) {

            // Create staff
            $staff = User::create($validated);

            // Error creating staff
            abort_if(!$staff, Response::HTTP_BAD_REQUEST, 'Operation failed - Create Staff');

            $branch = Branch::find($validated['branch_id']);
            abort_if(!$branch, Response::HTTP_BAD_REQUEST, 'Operation failed - Find Branch');

            // Set current branch for role assigning
            setPermissionsTeamId($branch->id);

            // Assign admin role with branch
            $staff->assignRole(RoleHelper::ROLE_STAFF);

            // Assign Staff to Branch
            $staff->branches()->attach($branch);
        });

        return response()->json(['message' => true], Response::HTTP_OK);
    }
}
