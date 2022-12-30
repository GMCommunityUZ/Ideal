<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graphic extends Model
{
    protected $guarded = ['id'];
    use HasFactory;
    public function student(){
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
    public function group(){
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

}
