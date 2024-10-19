<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'content'
    ];

    public function replies(){
        return $this->hasMany(Comment::class, 'parent_id')->with('replies');
    }
    public function parent(){
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
