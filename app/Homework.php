<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $table='homeworks';
    protected $fillable=['teacher_id', 'class_id', 'title', 'content', 'start_time', 'stop_time',];

    public function poster(){
        return $this->hasOne(User::class,'id','teacher_id');
    }

    public function classes(){
        return $this->hasOne(Classes::class,'id','class_id');
    }

    public function stuhomeworks(){
        return $this->hasMany(StuHomework::class,'homework_id','id');
    }
}
