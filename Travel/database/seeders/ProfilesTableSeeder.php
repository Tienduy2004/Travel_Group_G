<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\User;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Lấy tất cả người dùng đã tạo
       $users = User::all();

       // Tạo profile cho mỗi user
       foreach ($users as $user) {
           Profile::create([
               'user_id' => $user->id,
               'avatar' => 'avatar.png',  // Tạo avatar mặc định
               'cover_photo' => null,  // Tạo ảnh bìa mặc định
               'phone' => null,  // Điện thoại mẫu
               'address' => '123 Street, City',  // Địa chỉ mẫu
               'birthdate' => now()->subYears(25)->toDateString(),  // Ngày sinh mẫu (25 tuổi)
               'gender' => 'male',  // Giới tính mẫu
               'bio' => 'This is a sample bio text.',  // Mô tả mẫu
           ]);
       }
    }
}
