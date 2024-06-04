<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'Staff',
            'Parent',
            'Student',
            // 'Attendance',
            // 'Billing',
            // 'Report',
            // 'Event',
        ];

        foreach ($modules as $module) {
            Module::create(['name' => $module]);
        }
    }
}
