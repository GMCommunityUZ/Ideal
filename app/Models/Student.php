<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'phone_1',
        'phone_2',
        'group_id',
    ];
    use HasFactory;
    public function group(){
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}
