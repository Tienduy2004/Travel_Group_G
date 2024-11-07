<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartureSchedule extends Model
{
    use HasFactory;
    protected $table = 'departure_schedule';
    // Các thuộc tính có thể gán
    protected $fillable = [
        'tour_id',
        'date',
        'price',
        'seat_number', // số lượng ghế 
    ];

    

    // Định nghĩa mối quan hệ với Tour
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
