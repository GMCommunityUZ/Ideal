<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['teacher_id','name', 'amount_id', 'monday', 'tuesday', 'wednesday', 'friday', 'thursday', 'saturday', 'sunday', 'starts_at', 'ends_at' ];
    use HasFactory;
    public function teacher(){
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }
    public function amount(){
        return $this->belongsTo(Amount::class, 'amount_id', 'id');
    }
    public function students(){
        return $this->belongsTo(Student::class, 'id', 'group_id');
    }
}
