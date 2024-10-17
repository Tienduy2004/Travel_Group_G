<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripDirectory extends Model
{
    use HasFactory;
    protected $table = 'trip_directory'; // Tên bảng trong cơ sở dữ liệu

    protected $fillable = [
        'icon',   // Trường biểu tượng
        'title',  // Trường tiêu đề
    ];
    public function tripInformation()
    {
        return $this->hasMany(TripInformation::class, 'id_trip_directory','id');
    }
}
