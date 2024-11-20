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
        Friendship::create([
            'user_id' => $userId,
            'friend_id' => $friend_id,
            'status' => 'pending'
        ]);

        // Tạo mối quan hệ bạn bè ngược lại cho User 2 -> User 1 với trạng thái 'pending'
        Friendship::create([
            'user_id' => $friend_id,
            'friend_id' => $userId,
            'status' => 'pending'
        ]);

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

        // Xóa lời mời kết bạn từ Friend -> User (ngược lại)
        Friendship::where('user_id', $friend_id)
            ->where('friend_id', $userId)
            ->where('status', 'pending')
            ->delete();

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

        // Xóa bản ghi ngược lại (friendship từ User 2 đến User 1)
        Friendship::where('user_id', $userId)
            ->where('friend_id', $friend_id)
            ->delete();
        //dd($userId);
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

        // Kiểm tra xem quan hệ bạn bè có tồn tại hay không và có trạng thái pending
        $existingFriendship = Friendship::getFriendship($userId, $friend_id);

        if (!$existingFriendship) {
            return redirect()->back()->with('error', 'Người này chưa gửi lời mời kết bạn.');
        }

        // Chỉ cập nhật nếu trạng thái là 'pending', tránh cập nhật nếu đã là 'accepted' hoặc 'declined'
        if ($existingFriendship->status !== 'pending') {
            return redirect()->back()->with('error', 'Trạng thái kết bạn không hợp lệ.');
        }

        // Cập nhật trạng thái của mối quan hệ bạn bè từ 'pending' sang 'accepted'
        $existingFriendship->update(['status' => 'accepted']);

        // Cập nhật mối quan hệ ngược lại (từ friend_id -> user_id) thành 'accepted'
        Friendship::where('user_id', $userId)
            ->where('friend_id', $friend_id)
            ->update(['status' => 'accepted']);

        return redirect()->back()->with('success', 'Chấp nhận kết bạn thành công!');
    }
}
