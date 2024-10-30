<?php

namespace Database\Seeders;

use App\Models\Itinerary;
use App\Models\TripDirectory;
use App\Models\TripInformation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->call([
            DestinationSeeder::class,
            TourSeeder::class,
            ImageTourSeeder::class,
            ImportantInformationSeeder::class,
            TripDirectorySeeder::class,
            TripInformationSeeder::class,
            ItinerarySeeder::class,
            DepartureLocationSeeder::class,
            DepartureScheduleSeeder::class,
            FlightSeeder::class,
        ]);
    }
}
