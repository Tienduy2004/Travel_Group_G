<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartureLocation extends Model
{
    use HasFactory;
    // Đặt tên bảng nếu không phải là số nhiều
    protected $table = 'departure_location';

    // Các thuộc tính có thể gán
    protected $fillable = [
        'name',
    ];

    // Nếu bạn cần định nghĩa mối quan hệ với bảng khác, ví dụ: departure_schedule
    public function departureSchedules()
    {
        return $this->hasMany(Tour::class, 'id_departure_location');
    }
}
