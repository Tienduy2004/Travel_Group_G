<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{

    // Thêm bạn bè
    public function add(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);

        $friend_id = $request->input('friend_id');
        $userId = Auth::user()->id; // Lấy ID của người dùng hiện tại

        // Kiểm tra xem quan hệ bạn bè đã tồn tại chưa (bao gồm cả trạng thái pending và accepted)
        $existingFriendship = Friendship::getFriendship($userId, $friend_id);

        if ($existingFriendship) {
            return redirect()->back()->with('error', 'Bạn đã là bạn bè hoặc đã gửi yêu cầu kết bạn!');
        }

        // Tạo mối quan hệ bạn bè mới cho User 1 -> User 2 với trạng thái 'pending'
        Friendship::createFriendRequest($userId, $friend_id);


        return redirect()->back()->with('success', 'Gửi lời mời kết bạn thành công!');
    }

    // Hủy lời mời kết bạn
    public function cancelInvitation(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);

        $friend_id = $request->input('friend_id');
        $userId = Auth::user()->id; // Lấy ID của người dùng hiện tại

        // Kiểm tra xem có lời mời kết bạn chưa được chấp nhận
        $existingFriendship = Friendship::getFriendship($userId, $friend_id);

        if (!$existingFriendship || $existingFriendship->status !== 'pending') {
            return redirect()->back()->with('error', 'Không có lời mời kết bạn hoặc đã bị hủy/chấp nhận.');
        }

        // Xóa lời mời kết bạn từ User -> Friend
        $existingFriendship->delete();

        return redirect()->back()->with('success', 'Lời mời kết bạn đã bị hủy!');
    }

    // Hủy kết bạn
    public function cancel(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);

        $friend_id = $request->input('friend_id');
        $userId = Auth::user()->id; // Lấy ID của người dùng hiện tại

        // Kiểm tra xem quan hệ bạn bè đã tồn tại chưa
        $existingFriendship = Friendship::getFriendship($userId, $friend_id);

        if (!$existingFriendship) {
            return redirect()->back()->with('error', 'Bạn chưa kết bạn với người này.');
        }

        // Xóa quan hệ bạn bè giữa User 1 và User 2 (cả 2 bản ghi)
        $existingFriendship->delete();

        return redirect()->back()->with('success', 'Đã hủy lời mời kết bạn hoặc kết bạn.');
    }

    // Chấp nhận kết bạn
    public function accept(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);

        $friend_id = $request->input('friend_id');
        $userId = Auth::user()->id; // Lấy ID của người dùng hiện tại

        // Gọi phương thức acceptFriendRequest từ model Friendship
        $accepted = Friendship::acceptFriendRequest($userId, $friend_id);

        if (!$accepted) {
            return redirect()->back()->with('error', 'Không thể chấp nhận lời mời kết bạn. Vui lòng kiểm tra lại.');
        }

        return redirect()->back()->with('success', 'Chấp nhận kết bạn thành công!');
    }
}
