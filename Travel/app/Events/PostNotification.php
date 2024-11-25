<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;
    public $user;
    public $message;
    /**
     * Create a new event instance.
     */
    public function __construct(Post $post, $user, $message)
    {
        $this->post = $post;
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('post' . $this->post->id),
        ];
    }
    public function broadcastWith()
    {
        return [
            'user_name' => $this->user->name,
            'message' => $this->message,
            'avatar' => $this->user->profile ? asset('storage/' . $this->user->profile->avatar) : asset('img/default-avatar.png'),
        ];
    }
}
