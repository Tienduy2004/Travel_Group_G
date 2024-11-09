<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MessageController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        // Kiểm tra xem cuộc trò chuyện đã tồn tại chưa
        $conversation = Conversation::where(function($query) use ($request) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $request->receiver_id);
        })->orWhere(function($query) use ($request) {
            $query->where('receiver_id', Auth::id())
                  ->where('sender_id', $request->receiver_id);
        })->first();

        // Nếu không có cuộc trò chuyện, tạo mới
        if (!$conversation) {
            $conversation = Conversation::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $request->receiver_id,
            ]);
        }

        // Lưu tin nhắn
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        // Quay lại trang chat giữa người gửi và người nhận (show chat)
        return redirect()->route('chat.show', ['user_id' => $request->receiver_id]);
    }
}
