<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripInformation extends Model
{
    use HasFactory;
    protected $table = 'trip_information';

    protected $fillable = [
        'id_trip_directory',   
        'content',  
        'id_tour',
    ];
    public function tripDirectory()
    {
        return $this->belongsTo(tripDirectory::class, 'id_trip_directory');
    }
    
}
