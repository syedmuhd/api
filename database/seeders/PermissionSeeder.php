<?php

namespace Database\Seeders;

use App\Models\Modulepermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modulePermissions = [
            "View",
            "Read",
            "Write",
            "Create",
            "Delete"
        ];

        foreach ($modulePermissions as $modulePermission) {
            Modulepermission::create(['name' => $modulePermission]);
        }
    }
}
