<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'start_date',
        'end_date',
        'discount_percentage',
    ];

    // Khai báo để Laravel tự động cast cột ngày tháng thành đối tượng Carbon
    protected $dates = ['start_date', 'end_date'];

    /**
     * Lấy định dạng ngày bắt đầu.
     */
    public function getStartDateFormattedAttribute()
    {
        return $this->start_date ? $this->start_date->format('H:i d/m/Y') : null;
    }

    /**
     * Lấy định dạng ngày kết thúc.
     */
    public function getEndDateFormattedAttribute()
    {
        return $this->end_date ? $this->end_date->format('H:i d/m/Y') : null;
    }

    /**
     * Kiểm tra xem khuyến mãi đã hết hạn hay chưa.
     */
    public function getIsExpiredAttribute()
    {
        return $this->end_date && Carbon::now()->greaterThan($this->end_date);
    }
}
