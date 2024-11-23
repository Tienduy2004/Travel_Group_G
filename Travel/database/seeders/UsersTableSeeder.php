<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo 10 người dùng mẫu
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => 'User ' . ($i + 1),  // Tên người dùng là User 1, User 2, ..., User 10
                'email' => 'user' . ($i + 1) . '@example.com',  // Email ngẫu nhiên
                'password' => Hash::make('Tienduy@2004'),  // Đảm bảo password được mã hóa
            ]);
        }
    }
}
