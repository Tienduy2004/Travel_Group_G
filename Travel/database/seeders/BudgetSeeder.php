<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('budgets')->insert([
            ['name' => 'Dưới 5 triệu', 'min_price' => 0, 'max_price' => 5000000],
            ['name' => '5 - 10 triệu', 'min_price' => 5000000, 'max_price' => 10000000],
            ['name' => 'Trên 10 triệu', 'min_price' => 10000000, 'max_price' => null],
        ]);
    }
}
