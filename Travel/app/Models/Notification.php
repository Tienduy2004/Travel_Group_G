<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notification extends Model
{
    use HasFactory;

    // Thiết lập kiểu dữ liệu khóa chính là string
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'notifiable_id',
        'notifiable_type',
        'type',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array', // Chuyển đổi tự động từ JSON sang mảng và ngược lại
    ];

    // Tự động tạo UUID khi tạo mới bản ghi
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();  // Sinh UUID mới nếu chưa có
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'notifiable_id');
    }
}
