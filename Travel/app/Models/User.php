<?php

namespace App\Models;

use Carbon\Carbon;
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

    // Phương thức để lấy danh sách bạn bè
    public function getFriends()
    {
        return Friendship::where('status', 'accepted')
            ->where(function ($query) {
                // Kiểm tra quan hệ bạn bè đã chấp nhận
                $query->where('user_id', $this->id)
                    ->orWhere('friend_id', $this->id);
            })
            ->get()
            ->map(function ($friendship) {
                // Xác định ID của người bạn
                $friendId = ($friendship->user_id == $this->id) ? $friendship->friend_id : $friendship->user_id;

                // Tránh lấy chính người dùng
                if ($friendId != $this->id) {
                    $friend = User::find($friendId); // Lấy thông tin người bạn
                    // Trả về một mảng với thông tin về người bạn và thông tin về mối quan hệ friendship
                    return [
                        'friend' => $friend,  // Thông tin người bạn
                        'friendship' => $friendship // Thông tin mối quan hệ friendship
                    ];
                }

                return null; // Trả về null nếu là chính người dùng
            })
            ->filter() // Loại bỏ các giá trị null (chính người dùng)
            ->values(); // Đảm bảo trả về một mảng liên tiếp
    }

    public function suggestedFriends($friendIds)
    {
        return Friendship::where('status', 'accepted')
            ->where(function ($query) use ($friendIds) {
                // Kiểm tra quan hệ bạn bè đã chấp nhận dựa trên mảng ID bạn bè
                $query->whereIn('user_id', $friendIds)
                    ->orWhereIn('friend_id', $friendIds);
            })
            ->get()
            ->map(function ($friendship) use ($friendIds) {
                // Xác định ID của người bạn
                $friendId = in_array($friendship->user_id, $friendIds)
                    ? $friendship->friend_id
                    : $friendship->user_id;

                // Lấy thông tin người bạn
                $friend = User::find($friendId);

                // Nếu người bạn không phải là chính người dùng và không phải là bạn của người dùng hiện tại
                if ($friend && !in_array($friend->id, $friendIds)) {
                    return [
                        'friend' => $friend,        // Thông tin người bạn
                        'friendship' => $friendship // Thông tin mối quan hệ friendship
                    ];
                }

                return null; // Loại bỏ những người bạn đã là bạn của người dùng hiện tại
            })
            ->filter() // Loại bỏ giá trị null
            ->values(); // Đảm bảo mảng liên tiếp
    }

    public function mutualFriendsCount($friendId)
    {
        // Lấy danh sách ID bạn bè của người dùng hiện tại
        $friendIds = $this->getFriendsIds();

        // Tính số lượng bạn chung giữa người dùng hiện tại và người bạn có ID $friendId
        $mutualFriends = Friendship::where(function ($query) use ($friendIds, $friendId) {
            // Lọc các bạn của người bạn dựa trên ID
            $query->where(function ($query) use ($friendIds) {
                $query->whereIn('user_id', $friendIds)
                    ->orWhereIn('friend_id', $friendIds);
            })
                // Lọc theo người bạn đang xét
                ->where(function ($query) use ($friendId) {
                    $query->where('user_id', $friendId)
                        ->orWhere('friend_id', $friendId);
                });
        })
            ->where('status', 'accepted') // Chỉ lấy những quan hệ bạn bè đã chấp nhận
            ->count(); // Đếm số lượng bạn chung

        return $mutualFriends;
    }

    public function getFriendsIds()
    {
        return Friendship::where('status', 'accepted')
            ->where(function ($query) {
                $query->where('user_id', $this->id)
                    ->orWhere('friend_id', $this->id);
            })
            ->get()
            ->map(function ($friendship) {
                return $friendship->user_id == $this->id
                    ? $friendship->friend_id
                    : $friendship->user_id;
            })
            ->unique()
            ->values()
            ->toArray();
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->withPivot('status')
            ->wherePivot('status', 'accepted');
    }

    public function friendships()
    {
        return $this->hasMany(Friendship::class)
            ->where(function ($query) {
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
    public function likePost()
    {
        return $this->belongsToMany(Post::class, 'post_like');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getBirthdayFriends($friendsIds, $currentMonth)
    {
        return self::whereIn('users.id', $friendsIds) // Lọc bạn bè theo ID của bảng users
            ->join('profiles', 'users.id', '=', 'profiles.user_id') // Join bảng profiles
            ->whereNotNull('profiles.birthdate') // Đảm bảo rằng ngày sinh không rỗng
            ->select('users.id as user_id', 'profiles.birthdate', 'profiles.avatar', 'users.name') // Chọn các cột cần thiết
            ->get()
            ->groupBy(function ($date) {
                // Nhóm theo tháng sinh nhật
                return Carbon::parse($date->birthdate)->format('m');
            })
            ->sortBy(function ($group, $month) use ($currentMonth) {
                // Tính toán khoảng cách từ tháng hiện tại
                $month = (int) $month;
                return ($month >= $currentMonth) ? $month - $currentMonth : $month - $currentMonth + 12;
            });
    }
}
