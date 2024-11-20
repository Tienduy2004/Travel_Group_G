<?php

namespace App\Livewire\Friends;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FriendRequests extends Component
{
    public $pendingFriendRequests;

    public function mount()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Fetch the pending friend requests for the authenticated user
        $this->pendingFriendRequests = $user->receivedFriendRequests;
    }

    public function render()
    {
        //dd($this->pendingFriendRequests);
        // Pass the pending friend requests to the view
        return view('livewire.friends.friend-requests', [
            'pendingFriendRequests' => $this->pendingFriendRequests
        ]);
    }
}
