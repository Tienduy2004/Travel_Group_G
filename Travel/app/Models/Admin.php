<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements AuthenticatableContract
{
    use Notifiable;

    protected $guarded = []; // Hoặc bạn có thể định nghĩa các thuộc tính cho phép

    // Các phương thức khác của model
}
