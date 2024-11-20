<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function conversations()
    {

        return $this->hasMany(Conversation::class, 'sender_id')->orWhere('receiver_id', $this->id)->whereNotDeleted();
    }
    /**
     * The channels the user receives notification broadcasts on.
     */
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'users.' . $this->id;
    }

    // public function friends()
    // {
    //     return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
    //         ->where(function ($query) {
    //             // Lọc trạng thái là 'accepted' cho user_id
    //             $query->where('status', 'accepted')
    //                 ->where('user_id', $this->id);
    //         })
    //         ->orWhere(function ($query) {
    //             // Lọc trạng thái là 'accepted' cho friend_id
    //             $query->where('status', 'accepted')
    //                 ->where('friend_id', $this->id);
    //         })
    //         ->withPivot('user_id', 'friend_id', 'status', 'created_at', 'updated_at')  // Lấy thông tin từ bảng pivot
    //         ->with('profile');  // Eager load thông tin profile của bạn bè
    // }
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                    ->withPivot('user_id', 'friend_id', 'status', 'created_at', 'updated_at') // Lấy trường 'status' từ bảng 'friendships'
                    ->wherePivot('status', 'accepted'); // Chỉ lấy những người bạn có trạng thái 'accepted'
    }
    

    public function friendships()
    {
        return $this->hasMany(Friendship::class)->where(function ($query) {
            $query->where('user_id', $this->id)
                ->orWhere('friend_id', $this->id);
        });
    }
    public function receivedFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'friend_id')  // Lấy các yêu cầu mà người dùng nhận (friend_id là người nhận)
            ->where('status', 'pending')  // Trạng thái là "pending"
            ->with('user.profile');  // Eager load thông tin profile của người gửi lời mời
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function likePost(){
        return $this->belongsToMany(Post::class, 'post_like');
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
