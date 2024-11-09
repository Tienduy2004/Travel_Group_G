<?php

namespace App\Livewire;

use Livewire\Component;

class Chat extends Component
{
    public $selectedUser; // Người dùng đã chọn

    protected $listeners = ['userSelected' => 'selectUser']; // Lắng nghe sự kiện từ ChatList

    public function selectUser($userId)
    {
        $this->selectedUser = $userId; // Cập nhật người dùng đã chọn
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
