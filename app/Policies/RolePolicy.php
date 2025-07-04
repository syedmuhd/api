<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     * Check if user belongs to that branch
     */
    public function view(User $user, Role $role): bool
    {
        return $user->branches()->pluck("id")->contains($role->branch_id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, array $injected): bool
    {

        // Make sure branch is belongs to user
        $branchId = $injected['branches']['connect'];
        return $user->branches()->find($branchId)->count() ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $role): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        //
    }
}
