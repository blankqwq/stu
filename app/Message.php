<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $table = 'messages';
    protected $fillable = ['title', 'content', 'user_id', 'messagetable_id', 'messagetable_type', 'type_id'];


    public function messagetable()
    {
        return $this->morphTo();
    }

    public function types()
    {
        return $this->belongsTo(MessageType::class, 'id', 'type_id');
    }

    public function getCreatedAtAttribute($date)
    {
        if (Carbon::now() < Carbon::parse($date)->addDays(10)) {
            return Carbon::parse($date);
        }
        return Carbon::parse($date)->diffForHumans();
    }

    public function sender(){
        try{
            return User::with('getinfo')->find($this->user_id);
        }catch (\Exception $exception){
            return "0";
        }

    }

}
