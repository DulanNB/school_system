<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{

    protected $fillable = [
        'name',
        'email',
        'address',
        'contact_no',
        'admission_num',
        'age'
    ];
    public static function getAllStudents(){
        return  student::orderBy('id','desc')->paginate(10);
    }

}
