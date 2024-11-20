<?php

namespace App\Livewire\Friends;

use Livewire\Component;

class Index extends Component
{

    public $selectedTag = 'home'; // Mặc định là 'home'
    public $title = 'Trang chủ'; // Tiêu đề mặc định

    // Phương thức thay đổi tag
    public function setTag($tag)
    {
        $this->selectedTag = $tag;

        // Cập nhật tiêu đề dựa trên tag
        if ($tag === 'friend-requests') {
            $this->title = 'Lời mời kết bạn';
        } elseif ($tag === 'friends') {
            $this->title = 'Gợi ý';
        } elseif ($tag === 'all-friends') {
            $this->title = 'Tất cả bạn bè';
        } elseif ($tag === 'birthday-friends') {
            $this->title = 'Sinh nhật';
        } else {
            $this->title = 'Trang chủ';
        }
    }

    public function render()
    {
        return view('livewire.friends.index');
    }
}
