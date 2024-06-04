<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create super admin team
        $team = Team::create(['name' => 'Software Hub Sdn. Bhd.']);

        // Create super admin role
        Role::create([
            'name' => 'Super Administrator',
            'guard_name' => 'web',
            'team_id' => $team->id
        ]);

        $super = [
            'phone' => '60162731882',
            'name' => 'Software Hub',
            'email' => 'admin@softwarehub.my',
            'password' => Hash::make('password'),
            'team_id' => $team->id
        ];

        // Create super admin user
        $user = User::create($super);

        // Set team id
        setPermissionsTeamId($team->id);

        // Add into team
        $team->users()->attach($user);

        // Assign role
        $user->assignRole('Super Administrator');

        // Unset team id
        setPermissionsTeamId(null);
    }
}
