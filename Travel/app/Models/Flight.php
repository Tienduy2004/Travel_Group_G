<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    // Tên bảng
    protected $table = 'flights';

    // Các thuộc tính có thể gán trực tiếp
    protected $fillable = [
        'flight_code',
        'departure_date',
        'departure_time',
        'arrival_time',
        'departure_location',
        'arrival_location',
        'airline',
        'flight_type',
        'departure_schedule_id',
    ];

    public function departureSchedule()
    {
        return $this->belongsTo(DepartureSchedule::class);
    }

}
