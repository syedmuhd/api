<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'View',
            'Edit',
            'Create',
            'Delete'
        ];

        $modules = Module::all();

        foreach ($modules as $module) {
            foreach ($permissions as $permission) {
                $module->permissions()->save(Permission::create([
                    'name' => $permission . ' ' . $module->name,
                ]));
            }
        }
    }
}
