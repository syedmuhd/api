<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\RoleHelper;
use App\Helpers\StudentHelper;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * Register Student
 */

class RegisterStudentController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'password' => 'nullable|min:8',
            'email' => 'nullable|email',
        ]);

        $branchId = null;

        // Get branch id
        if (
            $request->user()->hasRole(RoleHelper::ROLE_ADMIN) ||
            $request->user()->hasRole(RoleHelper::ROLE_STAFF) ||
            $request->user()->hasRole(RoleHelper::ROLE_PARENT)
        ) {
            $branchId = $request->user()->branches[0]->id;
        }

        // If email is not provided, set a common email
        if (!isset($validated['email']) || !$validated['email']) {
            $validated['email'] = StudentHelper::EMAIL_COMMON;
        }

        // If password is not provided, set a common password
        if (!isset($validated['password']) || !$validated['password']) {
            $validated['password'] = StudentHelper::PASSWORD_COMMON;
        }

        DB::transaction(function () use ($validated, $branchId, $request) {

            // Create student
            $student = User::create($validated + ['branch_id' => $branchId]);

            // Error creating student
            abort_if(!$student, Response::HTTP_BAD_REQUEST, 'Operation failed - Create student');

            // Assign student role with branch
            $student->assignRole(RoleHelper::ROLE_STUDENT);

            // Assign student to Branch
            $branch = Branch::find($branchId);
            $student->branches()->attach($branch);

            // If parent is making this request
            // Assign student to her/his parent
            if ($request->user()->hasRole(RoleHelper::ROLE_PARENT)) {
                $parent = User::find($request->user()->id);
                $parent->students()->attach($student);
            }
        });

        return response()->json(['message' => true], Response::HTTP_OK);
    }
}
