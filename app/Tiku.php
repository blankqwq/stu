<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tiku extends Model
{
    protected $table='tiku';

    protected $fillable=['name','user_id','number'];
    public function task(){
        return $this->hasOne(QuestionTask::class,'task_id','id');
    }
    public function questions(){
        return $this->hasMany(Question::class,'tiku_id','id');
    }

//    public function
}
