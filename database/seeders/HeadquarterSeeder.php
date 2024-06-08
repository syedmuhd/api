<?php

namespace Database\Seeders;

use App\Models\Headquarter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeadquarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $headquarter = "Software Hub Sdn. Bhd.";
        Headquarter::create([
            'name' => $headquarter
        ]);
    }
}
