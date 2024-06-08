<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            HeadquarterSeeder::class,
            BranchSeeder::class,
            RoleSeeder::class,
            SuperAdministratorSeeder::class,
            ModuleSeeder::class,
            PermissionSeeder::class,
            DemoUserSeeder::class
        ]);
    }
}
