<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionTask extends Model
{
    protected $table='question_tasks';
    protected $fillable=['tiku_id', 'number', 'title','content', 'times'];
    public function tiku(){
        return $this->hasOne(Tiku::class,'tiku_id','id');
    }

//    public function
}
