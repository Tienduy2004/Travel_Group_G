<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public static function toggleBookmark($postId)
    {
        $user = auth()->user();

        // Kiểm tra xem bài viết đã được người dùng lưu chưa
        $existingBookmark = self::where('user_id', $user->id)
            ->where('post_id', $postId)
            ->first();

        if ($existingBookmark) {
            // Nếu đã lưu, xóa bookmark
            $existingBookmark->delete();
            return ['status' => 'removed'];
        } else {
            // Nếu chưa lưu, thêm bookmark mới
            self::create([
                'user_id' => $user->id,
                'post_id' => $postId,
            ]);
            return ['status' => 'added'];
        }
    }
    public static function getBookmarked($userId)
    {
        return self::where('user_id', $userId)
            ->with('post')
            ->get()
            ->pluck('post');
    }
    public static function removeBookmark($blogId)
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return self::where('user_id', $user->id)
            ->where('post_id', $blogId)
            ->delete();
    }
}
