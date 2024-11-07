<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TripDirectorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('trip_directory')->insert([
            ['icon' => 'sightseeing.svg', 'title' => 'Sightseeing'],
            ['icon' => 'cuisine.svg', 'title' => 'Cuisine'],
            ['icon' => 'suitable_object.svg', 'title' => 'Suitable Object'],
            ['icon' => 'ideal_time.svg', 'title' => 'Ideal time'],
            ['icon' => 'vehicle.svg', 'title' => 'Vehicle'],
            ['icon' => 'promotion.svg', 'title' => 'Promotion'],
        ]);
    }
}
