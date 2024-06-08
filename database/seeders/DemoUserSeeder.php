<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Headquarter;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        #1 Create Headquater
        #2 Create Branch
        #3 Associate Headquarter-Branch
        #4 Add default roles to Branch (branch_role)
        #5 Create User
        #6 Associate User-Role (user_role)
        #7 Associate User-Branch (user_branch)

        #1
        $headquarter = Headquarter::create(['name' => 'Demo School']);

        #2
        $branch = new Branch(['name' => 'Tropicana Aman']);

        #3
        $headquarter->branches()->save($branch);

        #4
        $defaultRoles = Role::getDefaultRoles();
        $branch->roles()->attach($defaultRoles);

        #5
        $user = User::create([
            'phone' => '0189192418',
            'email' => 'demo@sekolahapp.my',
            'password' => Hash::make('password'),
        ]);

        #6
        $user->roles()->attach(Role::firstWhere(['name' => Role::ROLE_ADMINISTRATOR]));
        $user->branches()->attach($branch);
    }
}
