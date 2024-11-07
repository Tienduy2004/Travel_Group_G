<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'is_featured'
    ];

    //quan he voi bang user
    public function user(){
        return $this->belongsTo(User::class);
    }
    //quan he voi bang categories
    public function category(){
        return $this->belongsTo(Category::class);
    }

    // lay tat ca bai viet
    public static function getPost(){
        return self::with('category', 'user')->paginate(6);
    }
    //  Lay so luong bai viet
    public static function totalPostCount(){
        return self::count();
    }
    // Lay so luong bai viet cua tung danh muc
    public static function getCategorywithPostCount(){
        return Category::withCount('posts')->get();
    }
    //Hien thi chi tiet bai viet
    public static function getTotalPost($postId){
        try {
            $id = Crypt::decrypt($postId);
            return self::with('user', 'category')->findOrFail($id);
        }
        catch(\Illuminate\Contracts\Encryption\DecryptException $e){
            return null; 
        }
    }
    //Hien thi bai viet theo danh muc
    public static function getPostWithCategory($categoryId){
        try {
            $id = Crypt::decrypt($categoryId);
            return self::where('category_id', $id)->with('category')->paginate(6);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return null;
        }
    }

    // Tim kiem bai viet
    public static function searchPost($query){
        return self::where('title', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%")
                    ->orWhereHas('user', function($q) use ($query){
                        $q->where('name', 'LIKE', "%{$query}%");
                    })
                    ->orWhereHas('category', function($q) use ($query){
                        $q->where('name', 'LIKE', "%{$query}%");
                    });
    }

}
