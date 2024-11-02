<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;
    // Đặt tên bảng (nếu khác với tên mặc định)
    protected $table = 'destination';

    // Đặt khóa chính (nếu khác với khóa chính mặc định)
    protected $primaryKey = 'id';

    // Nếu bạn không muốn sử dụng timestamps (created_at và updated_at)
    public $timestamps = false;

    // Định nghĩa các thuộc tính có thể được gán hàng loạt
    protected $fillable = [
        'name',
    ];

    // Nếu Destination có quan hệ với các bảng khác
    public function tours()
    {
        return $this->hasMany(Tour::class, 'id_destination');
    }
    public static function getSuggestions($keyword)
    {
        return self::where('name', 'LIKE', '%' . $keyword . '%')->pluck('name')->toArray();
    }
}
