<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'payment_method',
        'paid_status',
    ];
}
