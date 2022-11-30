<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Attendance extends Model
{
    use HasFactory;
    public function students(){return $this->belongsTo(Student::class,'student_id','id');}
}
