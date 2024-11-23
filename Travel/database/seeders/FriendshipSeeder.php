<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Friendship;
use App\Models\User;

class FriendshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả người dùng
        $users = User::all();

        // Tạo quan hệ bạn bè cho người dùng ngẫu nhiên
        foreach ($users as $user) {
            // Chọn ngẫu nhiên một người bạn trong danh sách người dùng
            $friends = $users->where('id', '!=', $user->id)->random(rand(1, 3));  // Chọn ngẫu nhiên 1-3 người bạn

            foreach ($friends as $friend) {
                // Tạo quan hệ bạn bè
                Friendship::create([
                    'user_id' => $user->id,
                    'friend_id' => $friend->id,
                    'status' => 'accepted',  // Mặc định trạng thái quan hệ là 'accepted'
                ]);
            }
        }
    }
}
