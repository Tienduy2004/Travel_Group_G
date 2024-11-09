<?php

namespace App\Livewire;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatBox extends Component
{
    public $messages = [
        ['sender' => 'Người dùng 1', 'message' => 'Chào bạn!'],
        ['sender' => 'Người dùng 2', 'message' => 'Chào bạn, có thể giúp gì không?'],
    ];  // Mẫu dữ liệu tin nhắn
    public $message = '';
    public $selectedUser;

    // Phương thức để gửi tin nhắn
    public function sendMessage()
    {
        $this->messages[] = ['sender' => 'Bạn', 'message' => $this->message];
        $this->message = '';  // Xóa ô nhập sau khi gửi
    }

    // Lắng nghe sự kiện từ component Chat
    public function updatedSelectedUser($value)
    {
        // Xử lý khi người dùng thay đổi
        $this->messages = [];  // Xóa tin nhắn khi thay đổi người dùng
    }

    public function render()
    {
        return view('livewire.chat-box');
    }
}
