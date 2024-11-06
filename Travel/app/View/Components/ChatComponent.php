<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ChatComponent extends Component
{
    public $messages;
    public $receiverId;

    public function __construct($messages, $receiverId)
    {
        $this->messages = $messages;
        $this->receiverId = $receiverId;
    }

    public function render()
    {
        return view('components.chat-component');
    }
}
