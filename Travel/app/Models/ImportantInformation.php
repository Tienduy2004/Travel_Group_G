<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportantInformation extends Model
{
    use HasFactory;
    protected $table = 'important_information';
    protected $fillable = [
        'tour_id',   
        'title',  // Trường tiêu đề
        'information',
    ];
}
