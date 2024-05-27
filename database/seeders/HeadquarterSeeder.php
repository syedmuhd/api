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
        $headquarters = [
            ['name' => 'Genius Aulad'],
            ['name' => 'Little Caliphs'],
            ['name' => 'Brainy Bunch'],
        ];

        Headquarter::insert($headquarters);
    }
}
