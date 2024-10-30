<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('flights')->insert([
            [
                'flight_code' => 'VN123',
                'departure_date' => '2025-01-16',
                'departure_time' => '12:00:00',
                'arrival_time' => '13:30:00',
                'departure_location' => 'SGN',
                'arrival_location' => 'BKK',
                'airline' => 'Vietnam Airlines',
                'flight_type' => 'one_way',
                'departure_schedule_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'flight_code' => 'VN456',
                'departure_date' => '2025-01-20',
                'departure_time' => '14:30:00',
                'arrival_time' => '16:10:00',
                'departure_location' => 'BKK',
                'arrival_location' => 'SGN',
                'airline' => 'Vietnam Airlines',
                'flight_type' => 'round_trip',
                'departure_schedule_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Thêm nhiều dữ liệu khác nếu cần
        ]);
    }
}
