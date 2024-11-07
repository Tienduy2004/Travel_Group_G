<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'numberofpost'
    ];

    // Mối quan hệ một danh mục có thể có nhiều bài viết
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    // Định nghĩa mối quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
