<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super = [
            'phone' => '60162731882',
            'name' => 'Software Hub',
            'email' => 'super@softwarehub.my',
            'password' => Hash::make('password'),
            'is_super' => 1
        ];

        User::create($super);
    }
}
