<?php

namespace App\Livewire;

use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatList extends Component
{
    public $users = [
        ['id' => 1, 'name' => 'Người dùng 1'],
        ['id' => 2, 'name' => 'Người dùng 2'],
        ['id' => 3, 'name' => 'Người dùng 3'],
    ];  // Mẫu dữ liệu người dùng
    public function selectUser($userId)
    {
        $this->emit('userSelected', $userId); // Phát sự kiện khi người dùng được chọn
    }
    public function render()
    {
        return view('livewire.chat-list');
    }
}
