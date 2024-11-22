<?php

namespace App\Livewire\Friends;

use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BirthdayFriends extends Component
{
    public function render()
    {
        // Lấy người dùng hiện tại
        $user = Auth::user();

        // Lấy danh sách ID bạn bè đã chấp nhận
        $friendsIds = $user->getFriendsIds();
        //dd($friendsIds);
        // Lấy tháng hiện tại
        $currentMonth = Carbon::now()->month;

        $birthdays = $user->getBirthdayFriends($friendsIds, $currentMonth);
        //dd($birthdays);

        return view('livewire.friends.birthday-friends', compact('birthdays'));
    }
}
