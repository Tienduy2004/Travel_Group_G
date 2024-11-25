<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostNotification extends Notification
{
    use Queueable;

    protected $post;
    protected $user;
    protected $type;
    protected $content;

    /**
     * Create a new notification instance.
     */
    public function __construct($post, $user, $type, $content = null)
    {
        $this->post = $post;
        $this->user = $user;
        $this->type = $type;
        $this->content = $content;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    public function toDatabase($notifiable)
    {
        // Kiểm tra người dùng và profile
        $user = $this->user;
        $userProfile = $user->profile ?? null;

        $message = match ($this->type) {
            'like' => "liked your post: '{$this->post->title}'",
            'comment' => "commented on your post: '{$this->content}'",
            'reply' => "replied to your comment: '{$this->content}'",
            default => 'Unknown activity',
        };

        return [
            'type' => $this->type,
            'message' => $message,
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'user_name' => $user->name,
            'avatar' => $userProfile && $userProfile->avatar
                ? asset('storage/' . $userProfile->avatar)
                : asset('img/default-avatar.png'),
        ];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
