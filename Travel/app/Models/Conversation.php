<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'receiver_id',
        'sender_id'
    ];


    public function messages()
    {
        return $this->hasMany(Message::class);
    }


    public function getReceiver()
    {

        if ($this->sender_id === Auth::id()) {

            return User::firstWhere('id', $this->receiver_id);
        } else {

            return User::firstWhere('id', $this->sender_id);
        }
    }



    public function scopeWhereNotDeleted($query)
    {
        $userId = Auth::id();

        return $query->where(function ($query) use ($userId) {

            #where message is not deleted
            $query->whereHas('messages', function ($query) use ($userId) {

                $query->where(function ($query) use ($userId) {
                    $query->where('sender_id', $userId)
                        ->whereNull('sender_deleted_at');
                })->orWhere(function ($query) use ($userId) {

                    $query->where('receiver_id', $userId)
                        ->whereNull('receiver_deleted_at');
                });
            })
                #include conversations without messages
                ->orWhereDoesntHave('messages');
        });
    }



    public  function isLastMessageReadByUser(): bool
    {


        $user = Auth::User();
        $lastMessage = $this->messages()->latest()->first();

        if ($lastMessage) {
            return  $lastMessage->read_at !== null && $lastMessage->sender_id == $user->id;
        }
    }




    public  function unreadMessagesCount(): int
    {


        return $unreadMessages = Message::where('conversation_id', '=', $this->id)
            ->where('receiver_id', Auth::user()->id)
            ->whereNull('read_at')->count();
    }

    public static function sendMessage($userId)
    {
        $authenticatedUserId = Auth::id();

        // Kiểm tra nếu cuộc trò chuyện đã tồn tại
        $existingConversation = self::where(function ($query) use ($authenticatedUserId, $userId) {
                $query->where('sender_id', $authenticatedUserId)
                    ->where('receiver_id', $userId);
            })->orWhere(function ($query) use ($authenticatedUserId, $userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $authenticatedUserId);
            })->first();

        if ($existingConversation) {
            // Trả về ID của cuộc trò chuyện hiện tại nếu đã tồn tại
            return $existingConversation;
        }

        // Nếu không có cuộc trò chuyện nào, tạo cuộc trò chuyện mới
        return self::create([
            'sender_id' => $authenticatedUserId,
            'receiver_id' => $userId,
        ]);
    }

    // Phương thức để xóa cuộc trò chuyện
    public static function deleteByUser($id)
    {
        // Lấy id người dùng hiện tại
        $userId = Auth::id();

        // Tìm cuộc trò chuyện
        $conversation = self::find(decrypt($id));

        // Nếu không tìm thấy cuộc trò chuyện
        if (!$conversation) {
            return false;
        }

        // Lặp qua tất cả các tin nhắn trong cuộc trò chuyện
        $conversation->messages()->each(function ($message) use ($userId) {
            if ($message->sender_id === $userId) {
                // Cập nhật trường `sender_deleted_at` khi người dùng là người gửi
                $message->update(['sender_deleted_at' => now()]);
            } elseif ($message->receiver_id === $userId) {
                // Cập nhật trường `receiver_deleted_at` khi người dùng là người nhận
                $message->update(['receiver_deleted_at' => now()]);
            }
        });

        // Kiểm tra xem người nhận cũng đã xóa tin nhắn của mình chưa
        $receiverAlsoDeleted = $conversation->messages()
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->where(function ($query) use ($userId) {
                $query->whereNull('sender_deleted_at')
                    ->orWhereNull('receiver_deleted_at');
            })
            ->doesntExist();

        // Nếu người nhận cũng đã xóa tất cả tin nhắn, thì xóa cuộc trò chuyện
        if ($receiverAlsoDeleted) {
            $conversation->forceDelete();
        }

        return true;
    }

    
}
