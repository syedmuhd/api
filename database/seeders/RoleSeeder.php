<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            Role::ROLE_SUPER_ADMINISTRATOR,
            Role::ROLE_ADMINISTRATOR,
            Role::ROLE_STAFF,
            Role::ROLE_PARENT,
            Role::ROLE_STUDENT
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role
            ]);
        }
    }
}
