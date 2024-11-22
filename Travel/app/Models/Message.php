<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'sender_id',
        'receiver_id',
        'conversation_id',
        'read_at',
        'receiver_deleted_at',
        'sender_deleted_at',
    ];


    protected $dates = ['read_at', 'receiver_deleted_at', 'sender_deleted_at'];


    /* relationship */

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }


    public function isRead(): bool
    {

        return $this->read_at != null;
    }

    public static function markMessagesAsRead($conversationId, $receiverId)
    {
        return self::where('conversation_id', $conversationId)
            ->where('receiver_id', $receiverId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public static function createMessage($conversationId, $body)
    {
        $senderId = Auth::id(); // Lấy ID người gửi từ session hiện tại
        $receiverId = Conversation::find($conversationId)->getReceiver()->id; // Lấy ID người nhận từ cuộc trò chuyện

        return self::create([
            'conversation_id' => $conversationId,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'body' => $body,
        ]);
    }

    /**
     * Quan hệ Message -> User (người gửi)
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Quan hệ Message -> User (người nhận)
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public static function loadMessages($conversationId, $paginateVar)
    {
        $userId = Auth::id();

        // Lấy các tin nhắn không bị xóa và có liên quan đến người dùng
        return self::with(['sender', 'receiver']) // Giúp tải trước các mối quan hệ để tránh n+1 query
            ->where('conversation_id', $conversationId)
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->whereNull('sender_deleted_at')
                    ->orWhere('receiver_id', $userId)
                    ->whereNull('receiver_deleted_at');
            })
            ->orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo (tùy thuộc vào yêu cầu)
            ->take($paginateVar) // Chỉ lấy số lượng tin nhắn cần thiết
            ->get();
    }
}
