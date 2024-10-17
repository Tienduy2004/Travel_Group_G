<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageTour extends Model
{
    use HasFactory;
    protected $table = 'image_tour';
    protected $fillable = [
        'tour_id',
        'image',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id', 'id');
    }
    
}
