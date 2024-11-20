<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Message;
use App\Notifications\MessageRead;
use App\Notifications\MessageSent;
use Illuminate\Support\Facades\Auth;

class ChatBox extends Component
{
    public $selectedConversation;
    public $body = '';
    public $loadedMessages;

    public $paginate_var = 10;

    protected $listeners = [
        'loadMore'
    ];


    public function getListeners()
    {

        $auth_id = Auth::user()->id;

        return [

            'loadMore',
            "echo-private:users.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'broadcastedNotifications'

        ];
    }

    public function broadcastedNotifications($event)
    {
        //dd($event);

        if ($event['type'] == MessageSent::class) {

            if ($event['conversation_id'] == $this->selectedConversation->id) {

                $this->dispatch('scroll-bottom');

                $newMessage = Message::find($event['message_id']);


                #push message
                $this->loadedMessages->push($newMessage);


                #mark as read
                $newMessage->read_at = now();
                $newMessage->save();

                #broadcast 
                $this->selectedConversation->getReceiver()
                    ->notify(new MessageRead($this->selectedConversation->id));
            }
        }
    }




    public function loadMore(): void
    {


        #increment 
        $this->paginate_var += 10;

        #call loadMessages()

        $this->loadMessages();


        #update the chat height 
        $this->dispatch('update-chat-height');
    }




    public function loadMessages()
    {

        $userId = Auth::id();
        #get count
        $count = Message::where('conversation_id', $this->selectedConversation->id)
            ->where(function ($query) use ($userId) {
                $query->where(function ($subQuery) use ($userId) {
                    $subQuery->where('sender_id', $userId)
                        ->whereNull('sender_deleted_at');
                })->orWhere(function ($subQuery) use ($userId) {
                    $subQuery->where('receiver_id', $userId)
                        ->whereNull('receiver_deleted_at');
                });
            })
            ->count();
        //dd($this->selectedConversation->id, $count);
        #skip and query
        $this->loadedMessages = Message::where('conversation_id', $this->selectedConversation->id)
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->whereNull('sender_deleted_at')
                    ->orWhere('receiver_id', $userId)
                    ->whereNull('receiver_deleted_at');
            })
            ->skip($count - $this->paginate_var)
            ->take($this->paginate_var)
            ->get();

        //dd($this->selectedConversation->id, $count, $this->loadedMessages);
        return $this->loadedMessages;
    }

    public function sendMessage()
    {
        //dd($this->body);

        $this->validate(['body' => 'required|string']);


        $createdMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedConversation->getReceiver()->id,
            'body' => $this->body

        ]);


        $this->reset('body');

        # Trigger Alpine.js to notice the change
        $this->dispatch('reset-body-input');

        #scroll to bottom
        $this->dispatch('scroll-bottom');


        #push the message
        $this->loadedMessages->push($createdMessage);


        #update conversation model
        $this->selectedConversation->updated_at = now();
        $this->selectedConversation->save();


        #refresh chatlist
        $this->dispatch('chat-list-refresh');
        //dd($this->dispatch('chat-list-refresh'));
        #broadcast

        $this->selectedConversation->getReceiver()
            ->notify(new MessageSent(
                Auth::User(),
                $createdMessage,
                $this->selectedConversation,
                $this->selectedConversation->getReceiver()->id

            ));
    }



    public function mount()
    {
        $this->loadMessages();
    }


    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
