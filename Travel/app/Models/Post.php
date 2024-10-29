<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'content',
        'image_url',
        'view_count',
        'is_featured',
        'status'
    ];

    //quan he voi bang user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //quan he voi bang categories
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // lay tat ca bai viet
    public static function getPost()
    {
        return self::where('status', 'approved')->with('category', 'user')->paginate(6);
    }
    //  Lay so luong bai viet
    public static function totalPostCount()
    {
        return self::where('status', 'approved')->count();
    }
    // Lay so luong bai viet cua tung danh muc
    public static function getCategorywithPostCount()
    {
        return Category::withCount([
            'posts' => function ($query) {
                $query->where('status', 'approved');
            }
        ])->get();
    }
    //Hien thi chi tiet bai viet
    public static function getTotalPost($postId)
    {
        try {
            $id = Crypt::decrypt($postId);
            return self::with('user', 'category')->findOrFail($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return null;
        }
    }
    //Hien thi bai viet theo danh muc
    public static function getPostWithCategory($categoryId)
    {
        try {
            $id = Crypt::decrypt($categoryId);
            return self::where('category_id', $id)->where('status', 'approved')->with('category')->paginate(6);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return null;
        }
    }

    // Tim kiem bai viet
    public static function searchPosts($query)
    {
        return self::where('title', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            });
    }

    //Tao bai viet
    public static function storePost($data)
    {
        return self::create([
            'user_id' => Auth::id(),
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'content' => $data['content'],
            'image_url' => $data['image_url'],
            'is_featured' => $data['is_featured'] ?? false,
            'status' => $data['status'] ?? 'pending',
        ]);
    }
}
