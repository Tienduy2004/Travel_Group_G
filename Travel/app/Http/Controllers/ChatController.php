<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $userId = $request->input('user_id');
        // $authenticatedUserId = Auth::id();

        // $existingConversation = Conversation::where(function ($query) use ($authenticatedUserId, $userId) {
        //         $query->where('sender_id', $authenticatedUserId)
        //             ->where('receiver_id', $userId);
        //     })->orWhere(function ($query) use ($authenticatedUserId, $userId) {
        //         $query->where('sender_id', $userId)
        //             ->where('receiver_id', $authenticatedUserId);
        //     })->first();

        // if ($existingConversation) {
        //     return redirect()->route('chat', ['query' => $existingConversation->id]);
        // }

        // $createdConversation = Conversation::create([
        //     'sender_id' => $authenticatedUserId,
        //     'receiver_id' => $userId,
        // ]);

        $conversation = Conversation::sendMessage($userId);

        return redirect()->route('chat', ['query' => $conversation->id]);
    }

    public function deleteByUser($id)
    {
         // Gọi phương thức deleteByUser từ model Conversation
         $result = Conversation::deleteByUser($id);

         if ($result) {
             return redirect()->route('chat.index')->with('success', 'Chat deleted successfully.');
         } else {
             return redirect()->route('chat.index')->with('error', 'Conversation not found.');
         }
    }
}
