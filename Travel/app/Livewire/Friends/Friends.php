<?php

namespace App\Livewire\Friends;

use Livewire\Component;
use App\Models\User;
use App\Models\Friendship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Friends extends Component
{
    public $userId;

    public function mount($userId)
    {
        $this->userId = $userId;
    }

    public function sendFriendRequest($friendId)
    {
        // Gọi phương thức tạo mối quan hệ bạn bè trong model Friendship
        $friendship = Friendship::createFriendRequest($this->userId, $friendId);

        if ($friendship) {
            session()->flash('message', 'Đã gửi lời mời kết bạn!');
        } else {
            session()->flash('error', 'Lỗi: Bạn đã gửi lời mời kết bạn hoặc đã là bạn bè!');
        }
    }

    public function getSuggestedFriends()
    {
        $currentUser = Auth::user();
        $friendIds = $currentUser->getFriendsIds(); // Lấy danh sách ID bạn bè

        // Lấy danh sách bạn bè của bạn bè nhưng trừ chính người dùng và bạn bè đã có
        $suggestedFriends = $currentUser->suggestedFriends($friendIds);

        // Lọc danh sách bạn bè gợi ý:
        // - Loại trừ chính người dùng
        // - Loại trừ những người đã là bạn
        // - Loại trừ những người đã nhận lời mời kết bạn từ bạn (status = 'pending')
        $suggestedFriends = $suggestedFriends->filter(function ($suggestedFriend) use ($currentUser) {
            $friendId = $suggestedFriend['friend']->id;
            return $friendId != $currentUser->id &&  // Loại trừ chính người dùng
                !in_array($friendId, $currentUser->getFriendsIds()) && // Loại trừ bạn bè đã có
                !Friendship::hasPendingRequest($currentUser->id, $friendId); // Loại trừ những người đã nhận lời mời kết bạn
        });

        // Thêm số lượng bạn chung vào từng người bạn gợi ý
        $suggestedFriends = $suggestedFriends->map(function ($suggestedFriend) use ($currentUser) {
            $suggestedFriend['friend']->mutualFriendsCount = $currentUser->mutualFriendsCount($suggestedFriend['friend']->id);
            return $suggestedFriend;
        });

        // Loại bỏ trùng lặp bạn bè
        $suggestedFriends = $suggestedFriends->unique(function ($suggestedFriend) {
            return $suggestedFriend['friend']->id; // Dùng ID của người bạn làm chỉ tiêu để loại bỏ trùng lặp
        });

        return $suggestedFriends;
    }

    // public function hasPendingRequest($friendId)
    // {
    //     $currentUser = Auth::user();

    //     // Kiểm tra xem người dùng hiện tại đã gửi lời mời kết bạn hay chưa
    //     return Friendship::where(function ($query) use ($currentUser, $friendId) {
    //         $query->where('user_id', $currentUser->id)
    //             ->where('friend_id', $friendId)
    //             ->where('status', 'pending');
    //     })
    //         ->orWhere(function ($query) use ($currentUser, $friendId) {
    //             $query->where('user_id', $friendId)
    //                 ->where('friend_id', $currentUser->id)
    //                 ->where('status', 'pending');
    //         })
    //         ->exists(); // Kiểm tra xem có tồn tại bản ghi nào không
    // }

    // public function mutualFriendsCount($friendId)
    // {
    //     // Lấy danh sách ID bạn bè của người dùng hiện tại
    //     $friendIds = $this->getFriendsIds();

    //     // Tính số lượng bạn chung giữa người dùng hiện tại và người bạn có ID $friendId
    //     $mutualFriends = Friendship::where(function ($query) use ($friendIds, $friendId) {
    //         // Lọc các bạn của người bạn dựa trên ID
    //         $query->where(function ($query) use ($friendIds) {
    //             $query->whereIn('user_id', $friendIds)
    //                 ->orWhereIn('friend_id', $friendIds);
    //         })
    //             // Lọc theo người bạn đang xét
    //             ->where(function ($query) use ($friendId) {
    //                 $query->where('user_id', $friendId)
    //                     ->orWhere('friend_id', $friendId);
    //             });
    //     })
    //         ->where('status', 'accepted') // Chỉ lấy những quan hệ bạn bè đã chấp nhận
    //         ->count(); // Đếm số lượng bạn chung
        
    //     return $mutualFriends;
    // }

    public function render()
    {

        $suggestedFriends = $this->getSuggestedFriends();
        //dd($suggestedFriends);
        return view('livewire.friends.friends', [
            'suggestedFriends' => $suggestedFriends,
        ]);
    }
}
