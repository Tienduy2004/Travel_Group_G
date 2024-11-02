<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartureScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departure_schedule')->insert([
            // Tháng 11/2024
            ['tour_id' => 1, 'date' => '2024-11-04', 'price' => 3000000, 'seat_number' => 12],
            ['tour_id' => 1, 'date' => '2024-11-10', 'price' => 3200000, 'seat_number' => 10],
            ['tour_id' => 2, 'date' => '2024-11-20', 'price' => 7500000, 'seat_number' => 15],
            ['tour_id' => 3, 'date' => '2024-11-18', 'price' => 8700000, 'seat_number' => 10],
            ['tour_id' => 4, 'date' => '2024-11-05', 'price' => 9600000, 'seat_number' => 8],
            ['tour_id' => 5, 'date' => '2024-11-15', 'price' => 11000000, 'seat_number' => 20],
            ['tour_id' => 6, 'date' => '2024-11-20', 'price' => 9900000, 'seat_number' => 12],
            ['tour_id' => 7, 'date' => '2024-11-25', 'price' => 14500000, 'seat_number' => 9],
            ['tour_id' => 8, 'date' => '2024-11-30', 'price' => 13800000, 'seat_number' => 10],
            ['tour_id' => 9, 'date' => '2024-11-15', 'price' => 8000000, 'seat_number' => 18],
            ['tour_id' => 10, 'date' => '2024-11-18', 'price' => 12000000, 'seat_number' => 7],
            ['tour_id' => 11, 'date' => '2024-11-22', 'price' => 7800000, 'seat_number' => 10],
            ['tour_id' => 12, 'date' => '2024-11-24', 'price' => 8800000, 'seat_number' => 12],
            ['tour_id' => 13, 'date' => '2024-11-28', 'price' => 22000000, 'seat_number' => 5],
            ['tour_id' => 14, 'date' => '2024-11-30', 'price' => 24800000, 'seat_number' => 14],
            ['tour_id' => 15, 'date' => '2024-11-15', 'price' => 29500000, 'seat_number' => 10],
        
            // Tháng 12/2024
            ['tour_id' => 1, 'date' => '2024-12-04', 'price' => 3000000, 'seat_number' => 12],
            ['tour_id' => 1, 'date' => '2024-12-10', 'price' => 3200000, 'seat_number' => 10],
            ['tour_id' => 2, 'date' => '2024-12-20', 'price' => 7500000, 'seat_number' => 15],
            ['tour_id' => 3, 'date' => '2024-12-18', 'price' => 8700000, 'seat_number' => 10],
            ['tour_id' => 4, 'date' => '2024-12-05', 'price' => 9600000, 'seat_number' => 8],
            ['tour_id' => 5, 'date' => '2024-12-15', 'price' => 11000000, 'seat_number' => 20],
            ['tour_id' => 6, 'date' => '2024-12-20', 'price' => 9900000, 'seat_number' => 12],
            ['tour_id' => 7, 'date' => '2024-12-25', 'price' => 14500000, 'seat_number' => 9],
            ['tour_id' => 8, 'date' => '2024-12-30', 'price' => 13800000, 'seat_number' => 10],
            ['tour_id' => 9, 'date' => '2024-12-15', 'price' => 8500000, 'seat_number' => 18],
            ['tour_id' => 10, 'date' => '2024-12-15', 'price' => 12500000, 'seat_number' => 7],
            ['tour_id' => 11, 'date' => '2024-12-18', 'price' => 7500000, 'seat_number' => 10],
            ['tour_id' => 12, 'date' => '2024-12-20', 'price' => 8700000, 'seat_number' => 12],
            ['tour_id' => 13, 'date' => '2024-12-25', 'price' => 21900000, 'seat_number' => 5],
            ['tour_id' => 14, 'date' => '2024-12-30', 'price' => 24800000, 'seat_number' => 14],
            ['tour_id' => 15, 'date' => '2024-12-15', 'price' => 29500000, 'seat_number' => 10],
        
            // Tháng 1/2025
            ['tour_id' => 1, 'date' => '2025-01-05', 'price' => 3100000, 'seat_number' => 15],
            ['tour_id' => 2, 'date' => '2025-01-10', 'price' => 7200000, 'seat_number' => 18],
            ['tour_id' => 3, 'date' => '2025-01-12', 'price' => 8900000, 'seat_number' => 10],
            ['tour_id' => 4, 'date' => '2025-01-15', 'price' => 9500000, 'seat_number' => 8],
            ['tour_id' => 5, 'date' => '2025-01-18', 'price' => 11500000, 'seat_number' => 20],
            ['tour_id' => 6, 'date' => '2025-01-20', 'price' => 9900000, 'seat_number' => 12],
            ['tour_id' => 7, 'date' => '2025-01-25', 'price' => 14900000, 'seat_number' => 9],
            ['tour_id' => 8, 'date' => '2025-01-30', 'price' => 13800000, 'seat_number' => 10],
            ['tour_id' => 9, 'date' => '2025-01-15', 'price' => 8000000, 'seat_number' => 18],
            ['tour_id' => 10, 'date' => '2025-01-18', 'price' => 12500000, 'seat_number' => 7],
            ['tour_id' => 11, 'date' => '2025-01-20', 'price' => 7800000, 'seat_number' => 10],
            ['tour_id' => 12, 'date' => '2025-01-22', 'price' => 8800000, 'seat_number' => 12],
            ['tour_id' => 13, 'date' => '2025-01-28', 'price' => 21900000, 'seat_number' => 5],
            ['tour_id' => 14, 'date' => '2025-01-30', 'price' => 24800000, 'seat_number' => 14],
            ['tour_id' => 15, 'date' => '2025-01-15', 'price' => 29500000, 'seat_number' => 10],
        
            // Tháng 2/2025
            ['tour_id' => 1, 'date' => '2025-02-05', 'price' => 3200000, 'seat_number' => 15],
            ['tour_id' => 2, 'date' => '2025-02-10', 'price' => 7400000, 'seat_number' => 12],
            ['tour_id' => 3, 'date' => '2025-02-15', 'price' => 8800000, 'seat_number' => 10],
            ['tour_id' => 4, 'date' => '2025-02-20', 'price' => 9600000, 'seat_number' => 8],
            ['tour_id' => 5, 'date' => '2025-02-25', 'price' => 12000000, 'seat_number' => 20],
            ['tour_id' => 6, 'date' => '2025-02-28', 'price' => 10500000, 'seat_number' => 12],
            ['tour_id' => 7, 'date' => '2025-02-27', 'price' => 15000000, 'seat_number' => 9],
            ['tour_id' => 8, 'date' => '2025-02-28', 'price' => 14000000, 'seat_number' => 10],
            ['tour_id' => 9, 'date' => '2025-02-15', 'price' => 8500000, 'seat_number' => 18],
            ['tour_id' => 10, 'date' => '2025-02-18', 'price' => 12500000, 'seat_number' => 7],
            ['tour_id' => 11, 'date' => '2025-02-20', 'price' => 7800000, 'seat_number' => 10],
            ['tour_id' => 12, 'date' => '2025-02-22', 'price' => 8700000, 'seat_number' => 12],
            ['tour_id' => 13, 'date' => '2025-02-25', 'price' => 22000000, 'seat_number' => 5],
            ['tour_id' => 14, 'date' => '2025-02-28', 'price' => 25000000, 'seat_number' => 14],
            ['tour_id' => 15, 'date' => '2025-02-15', 'price' => 29000000, 'seat_number' => 10],
        ]);
    }
}
