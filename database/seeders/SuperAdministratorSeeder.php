<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super = [
            'phone' => '60162731882',
            'email' => 'admin@softwarehub.my',
            'password' => Hash::make('password'),
        ];

        // Create super admin user
        $user = User::create($super);

        $superAdministratorRole = Role::firstWhere([
            'name' => Role::ROLE_SUPER_ADMINISTRATOR
        ]);

        // Assign role super admin
        $user->roles()->attach($superAdministratorRole);

        $branch = Branch::find(1);

        // Assign branch software hub sdn bhd, shah alam
        $user->branches()->attach($branch);

        $roles = Role::find([1, 2, 3, 4, 5]);

        $branch->roles()->attach($roles);
    }
}
