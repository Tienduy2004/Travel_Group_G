<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageTourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('image_tour')->insert([
            ['tour_id' => 1, 'image' => 'vietnam-hanoi-1.jpg'],
            ['tour_id' => 1, 'image' => 'vietnam-hanoi-2.jpg'],
            ['tour_id' => 2, 'image' => 'thailand-bangkok-1.jpg'],
            ['tour_id' => 2, 'image' => 'thailand-bangkok-2.jpg'],
            ['tour_id' => 3, 'image' => 'japan-tokyo-1.jpg'],
            ['tour_id' => 3, 'image' => 'japan-tokyo-2.jpg'],
            ['tour_id' => 4, 'image' => 'korea-seoul-1.jpg'],
            ['tour_id' => 4, 'image' => 'korea-seoul-2.jpg'],
            ['tour_id' => 5, 'image' => 'usa-new-york-1.jpg'],
            ['tour_id' => 5, 'image' => 'usa-new-york-2.jpg'],
            ['tour_id' => 6, 'image' => 'uk-london-1.jpg'],
            ['tour_id' => 6, 'image' => 'uk-london-2.jpg'],
            ['tour_id' => 7, 'image' => 'france-paris-1.jpg'],
            ['tour_id' => 7, 'image' => 'france-paris-2.jpg'],
            ['tour_id' => 8, 'image' => 'australia-sydney-1.jpg'],
            ['tour_id' => 8, 'image' => 'australia-sydney-2.jpg'],
            ['tour_id' => 9, 'image' => 'canada-toronto-1.jpg'],
            ['tour_id' => 9, 'image' => 'canada-toronto-2.jpg'],
            ['tour_id' => 10, 'image' => 'india-delhi-1.jpg'],
            ['tour_id' => 10, 'image' => 'india-delhi-2.jpg'],
            ['tour_id' => 11, 'image' => 'malaysia-kuala-lumpur-1.jpg'],
            ['tour_id' => 11, 'image' => 'malaysia-kuala-lumpur-2.jpg'],
            ['tour_id' => 12, 'image' => 'singapore-marina-bay-1.jpg'],
            ['tour_id' => 12, 'image' => 'singapore-marina-bay-2.jpg'],
            ['tour_id' => 13, 'image' => 'spain-barcelona-1.jpg'],
            ['tour_id' => 13, 'image' => 'spain-barcelona-2.jpg'],
            ['tour_id' => 14, 'image' => 'italy-rome-1.jpg'],
            ['tour_id' => 14, 'image' => 'italy-rome-2.jpg'],
            ['tour_id' => 15, 'image' => 'germany-berlin-1.jpg'],
            ['tour_id' => 15, 'image' => 'germany-berlin-2.jpg'],
        ]);
    }
}
