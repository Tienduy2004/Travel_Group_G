<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class FriendList extends Component
{

    public $friends;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $user = Auth::user();
        $this->friends = $user ? $user->getfriends() : [];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.friend-list');
    }
}
