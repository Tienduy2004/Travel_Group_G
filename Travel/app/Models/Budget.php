<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $table = 'budgets'; // Tên bảng trong cơ sở dữ liệu
    protected $fillable = ['name', 'min_price', 'max_price']; // Các trường có thể gán hàng loạt

    public static function getBudgetRange($budgetOption)
    {
        return self::where('name', $budgetOption)->first();
    }
}
