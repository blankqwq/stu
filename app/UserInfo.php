<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $fillable=['name','user_id','sign','avatar', 'sex'];
    //

    public function user(){
        return $this->belongsTo(User::class,'id','user_id');
    }
}
