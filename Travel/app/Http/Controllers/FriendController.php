<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);

        $friend_id = $request->input('friend_id');
        $userId = Auth::user()->id; // Lấy ID của người dùng hiện tại

        // Kiểm tra xem quan hệ bạn bè đã tồn tại chưa
        $existingFriendship = Friendship::getFriendship($userId,$friend_id);

        if ($existingFriendship) {
            return redirect()->back()->with('error', 'Bạn đã là bạn bè hoặc đã gửi yêu cầu kết bạn!');
        }

        // Tạo một mối quan hệ bạn bè mới
        Friendship::create([
            'user_id' => $userId,
            'friend_id' => $friend_id,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Thêm bạn bè thành công!');
    }

    public function cancel(Request $request){

        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);

        $friend_id = $request->input('friend_id');
        $userId = Auth::user()->id; // Lấy ID của người dùng hiện tại

        // Kiểm tra xem quan hệ bạn bè đã tồn tại chưa
        $existingFriendship = Friendship::getFriendship($userId,$friend_id);
           

        if (!$existingFriendship) {
            return redirect()->back()->with('error', 'Bạn chưa thêm bạn bè với người này.');
        }

        // Tạo xóa mối quan hệ bạn bè 
        $existingFriendship->delete();

        return redirect()->back()->with('success', 'Thêm bạn bè thành công!');
    }

    public function accept(Request $request) {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);

        $friend_id = $request->input('friend_id');
        $userId = Auth::user()->id; // Lấy ID của người dùng hiện tại

        // Kiểm tra xem quan hệ bạn bè đã tồn tại chưa
        $existingFriendship = Friendship::getFriendship($userId,$friend_id);
           

        if (!$existingFriendship) {
            return redirect()->back()->with('error', 'Người này chưa gửi lời mời kết bạn.');
        }
 
        // Tạo một mối quan hệ bạn bè mới
        $existingFriendship->update([
            'status' => 'accepted',
        ]); 

        return redirect()->back()->with('success', 'Accept bạn bè thành công!');
    }
}
