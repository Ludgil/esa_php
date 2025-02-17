<?php

namespace Database\Seeders;

use App\Models\Pony;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PonySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ponies = [
            ['name' => 'Gros Papa Noël'],
            ['name' => 'Poneyrminator'],
            ['name' => 'Poneyzilla'],
            ['name' => 'Lardon'],
            ['name' => 'Biscuit'],
            ['name' => 'Cacahuète'],
            ['name' => 'Zigzag'],
            ['name' => 'Pépito'],
            ['name' => 'Usain Bolt'],
            ['name' => 'Trump'],
        ];
        foreach ($ponies as $pony) {
            Pony::create($pony);
        }
    }
}
