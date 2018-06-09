<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table='questions';

    public function types(){
        return $this->hasOne(QuestionTask::class,'type_id','id');
    }

    public function tiku(){
        return $this->hasOne(Tiku::class,'id','tiku_id');
    }

//    public function
}
