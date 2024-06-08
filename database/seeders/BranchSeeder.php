<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Headquarter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branch = new Branch(['name' => 'Shah Alam']);

        Headquarter::firstWhere([
            'name' => 'Software Hub Sdn. Bhd.'
        ])->branches()->save($branch);
    }
}
