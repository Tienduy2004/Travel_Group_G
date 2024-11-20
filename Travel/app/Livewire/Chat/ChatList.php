<?php

namespace App\Livewire\Chat;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Conversation;

class ChatList extends Component
{
    public $selectedConversation;
    public $query;


    protected $listeners = ['chat-list-refresh' => '$refresh'];

    public function getListeners()
    {
        $auth_id = Auth::user()->id;

        return [
            'chat-list-refresh' => '$refresh',
            "echo-private:users.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'handleBroadcastedNotifications',
        ];
    }

    public function handleBroadcastedNotifications($event)
    {
        //dd($event);
        // Nếu sự kiện là gửi tin nhắn
        if ($event['type'] == \App\Notifications\MessageSent::class) {
            // Làm mới danh sách chat khi có tin nhắn mới
            $this->dispatch('chat-list-refresh');
        }
    }

    public function deleteByUser($id)
    {

        $userId = Auth::id();
        $conversation = Conversation::find(decrypt($id));




        $conversation->messages()->each(function ($message) use ($userId) {

            if ($message->sender_id === $userId) {

                $message->update(['sender_deleted_at' => now()]);
            } elseif ($message->receiver_id === $userId) {

                $message->update(['receiver_deleted_at' => now()]);
            }
        });


        $receiverAlsoDeleted = $conversation->messages()
            ->where(function ($query) use ($userId) {

                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })->where(function ($query) use ($userId) {

                $query->whereNull('sender_deleted_at')
                    ->orWhereNull('receiver_deleted_at');
            })->doesntExist();



        if ($receiverAlsoDeleted) {

            $conversation->forceDelete();
            # code...
        }



        return redirect(route('chat.index'));
    }



    public function render()
    {

        $user = Auth::user();
        return view('livewire.chat.chat-list', [
            'conversations' => $user->conversations()->latest('updated_at')->get()
        ]);
    }
}
