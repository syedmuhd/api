<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Headquarter;
use App\Models\Profile;
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

        $headquarter = Headquarter::create([
            'name' => "Software Hub Sdn. Bhd."
        ]);

        $branch = new Branch(['name' => 'Shah Alam']);

        $headquarter->branches()->save($branch);

        // create roles for branch
        $roles = [
            Role::ROLE_SUPER_ADMINISTRATOR,
            Role::ROLE_ADMINISTRATOR,
            Role::ROLE_STAFF,
            Role::ROLE_PARENT,
            Role::ROLE_STUDENT
        ];

        foreach ($roles as $role) {
            Branch::find(1)->roles()->save(new Role(['name' => $role]));
        }

        $superAdministratorRole = Role::firstWhere([
            'name' => Role::ROLE_SUPER_ADMINISTRATOR
        ]);

        $super = [
            'role_id' => $superAdministratorRole->id,
            'phone' => '60162731882',
            'email' => 'admin@softwarehub.my',
            'password' => Hash::make('password'),
        ];

        // Create super admin user
        $user = User::create($super);

        $profile = new Profile(["name" => "Super Administrator"]);
        $user->profile()->save($profile);

        $branch = Branch::find(1);

        // Assign branch to user
        $user->branches()->attach($branch);
    }
}
