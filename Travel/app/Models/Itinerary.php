<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory;
    protected $table = 'itinerary';
    protected $fillable = [
        'tour_id',   
        'title',  // Trường tiêu đề
        'description',
    ];
}
