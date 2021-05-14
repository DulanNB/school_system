<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courses extends Model
{

    protected $fillable = [
        'course_name',
        'value',
        'credits',
    ];
    public static function getAllCourses(){
        return  courses::orderBy('id')->paginate(10);
    }
}
