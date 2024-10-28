<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';

   
    protected $fillable = [
        'tour_id',
        'departure_schedule_id',
        'user_id',
        'contact_name',
        'contact_email',
        'contact_phone',
        'contact_address',
        'adult_count',
        'child_count',
        'single_rooms',
        'total_price',
        'note',
        'payment_method',
        'booking_status',
    ];
    
    
    // Mối quan hệ với Passenger
    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
    public function DepartureSchedule()
    {
        return $this->belongsTo(DepartureSchedule::class);
    }
}
