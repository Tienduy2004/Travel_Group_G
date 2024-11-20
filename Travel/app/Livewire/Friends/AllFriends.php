<?php

namespace App\Livewire\Friends;

use App\Models\Friendship;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AllFriends extends Component
{

    public $allFriends; // Khai báo property để lưu danh sách bạn bè

    public function mount()
    {
        // Lấy tất cả bạn bè đã được chấp nhận của người dùng hiện tại
        $user = Auth::user();
        $this->allFriends = $user->friends;
    }

    public function render()
    {
       
        return view('livewire.friends.all-friends');
    }
}
