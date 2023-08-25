<?php

namespace Database\Seeders;

use App\Models\PickupPoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PickupPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PickupPoint::factory(10)->create();
    }
}
