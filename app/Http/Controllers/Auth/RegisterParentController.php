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
 * Register Parent
 */

class RegisterParentController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $branchId = null;

        // if role is staff, get staff branch id
        if ($request->user()->hasRole(RoleHelper::ROLE_STAFF)) {
            $branchId = $request->user()->branches[0]->id;
        }

        DB::transaction(function () use ($validated, $branchId) {

            // Create parent
            $parent = User::create($validated + ['branch_id' => $branchId]);

            // Error creating parent
            abort_if(!$parent, Response::HTTP_BAD_REQUEST, 'Operation failed - Create parent');

            // Assign parent role with branch
            $parent->assignRole(RoleHelper::ROLE_PARENT);

            // Assign parent to Branch
            $branch = Branch::find($branchId);
            $parent->branches()->attach($branch);
        });

        return response()->json(['message' => true], Response::HTTP_OK);
    }
}
