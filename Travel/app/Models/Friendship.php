<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    protected $fillable = ['user_id', 'friend_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    public static function isSender($user_id)
    {
        // Kiểm tra xem id có phải là user_id hay không
        return self::where('user_id', $user_id)->exists();
    }

    // Phương thức để tạo mối quan hệ bạn bè
    public static function createFriendRequest($userId, $friendId)
    {
        // Kiểm tra xem mối quan hệ đã tồn tại chưa (bao gồm cả pending và accepted)
        $existingFriendship = self::where(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $userId)->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $friendId)->where('friend_id', $userId);
        })->first();

        // Nếu mối quan hệ chưa tồn tại thì tạo mới
        if (!$existingFriendship) {
            return self::create([
                'user_id' => $userId,
                'friend_id' => $friendId,
                'status' => 'pending',
            ]);
        }

        // Nếu mối quan hệ đã tồn tại, có thể trả về false hoặc xử lý thêm tùy theo yêu cầu
        return false;
    }
    
    // Phương thức kiểm tra xem có lời mời kết bạn chưa xử lý không
    public static function hasPendingRequest($currentUserId, $friendId)
    {
        return self::where(function ($query) use ($currentUserId, $friendId) {
            $query->where('user_id', $currentUserId)
                ->where('friend_id', $friendId)
                ->where('status', 'pending');
        })
            ->orWhere(function ($query) use ($currentUserId, $friendId) {
                $query->where('user_id', $friendId)
                    ->where('friend_id', $currentUserId)
                    ->where('status', 'pending');
            })
            ->exists();
    }

    public static function getFriendship($userId, $friendId)
    {
        return self::where(function ($query) use ($userId, $friendId) {
            $query->where(function ($subQuery) use ($userId, $friendId) {
                $subQuery->where('user_id', $userId)
                          ->where('friend_id', $friendId);
            })->orWhere(function ($subQuery) use ($userId, $friendId) {
                $subQuery->where('user_id', $friendId)
                          ->where('friend_id', $userId);
            });
        })->first(); // Lấy một kết quả đầu tiên
    }

    // Phương thức chấp nhận kết bạn
    public static function acceptFriendRequest($userId, $friendId)
    {
        // Kiểm tra xem mối quan hệ bạn bè có tồn tại và trạng thái là 'pending'
        $friendship = self::getFriendship($userId, $friendId);

        if (!$friendship) {
            return false; // Mối quan hệ không tồn tại
        }

        // Kiểm tra trạng thái hiện tại của quan hệ bạn bè
        if ($friendship->status !== 'pending') {
            return false; // Trạng thái không phải 'pending'
        }

        // Cập nhật trạng thái thành 'accepted'
        $friendship->update(['status' => 'accepted']);

        return true; // Cập nhật thành công
    }
   
}
