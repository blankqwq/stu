<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $table='messages';
    protected $fillable=['title','content','user_id','messagetable_id','messagetable_type','type_id'];


    public function messagetable(){
        return $this->morphTo();
    }

    public function types(){
        return $this->belongsTo(MessageType::class,'id','type_id');
    }


}
