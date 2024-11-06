<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;


Broadcast::channel('chat.{receiverId}', function ($user, $receiverId) {
    Log::info("User ID: {$user->id}, Receiver ID: {$receiverId}"); // Log để kiểm tra ID
    return (int) $user->id === (int) $receiverId; 
});
