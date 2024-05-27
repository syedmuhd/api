<?php

namespace App\Http\Controllers\Super\Auth;

use App\Helpers\RoleHelper;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Headquarter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

/**
 * Register Admin
 * Only Super can execute this
 */

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        /**
         * Super is allowed
         */
        abort_if(!$request->user()->is_super, Response::HTTP_BAD_REQUEST, 'Operation is not permitted');

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'hq_id' => 'required|integer',
            'branch_name' => 'required|string'
        ]);

        DB::transaction(function () use ($validated) {

            // Create admin
            $admin = User::create($validated);

            // Error creating admin
            abort_if(!$admin, Response::HTTP_BAD_REQUEST, 'Operation failed - Create Admin');

            $hq = Headquarter::find($validated['hq_id']);
            abort_if(!$hq, Response::HTTP_BAD_REQUEST, 'Operation failed - Find HQ');

            // Create branch (known as "team" from role perspective)
            $branch = Branch::create([
                'headquarter_id' => $hq->id,
                'name' => $validated['branch_name']
            ]);

            abort_if(!$hq, Response::HTTP_BAD_REQUEST, 'Operation failed - Create Branch');

            // Set current branch for role assigning
            setPermissionsTeamId($branch->id);

            // Assign admin role with branch
            $admin->assignRole(RoleHelper::ROLE_ADMIN);

            // Assign Branch to HQ
            $branch->headquarter()->associate($hq);

            // Assign Admin to Branch
            $admin->branches()->attach($branch);
        });

        return response()->json(['message' => true], Response::HTTP_OK);
    }
}
