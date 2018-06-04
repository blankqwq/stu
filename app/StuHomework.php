<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StuHomework extends Model
{
    protected $fillable=['content','attachment','user_id','homework_id','fraction'];
    public function stuser(){
        return $this->hasOne(User::class,'id','user_id')->with('getinfo');
    }

    public function homeworks(){
        return $this->belongsTo(Homework::class,'homework_id','id');
    }
}
