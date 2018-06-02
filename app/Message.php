<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    protected $table = 'messages';
    protected $fillable = ['title', 'content', 'user_id', 'messagetable_id', 'messagetable_type', 'type_id','can_reply','enclosure_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function messagetable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 类型
     */
    public function types()
    {
        return $this->belongsTo(MessageType::class, 'type_id', 'id');
    }

    /**
     * @param $date
     * @return string|static
     */
    public function getCreatedAtAttribute($date)
    {
        if (Carbon::now() < Carbon::parse($date)->addDays(10)) {
            return Carbon::parse($date);
        }
        return Carbon::parse($date)->diffForHumans();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|string|static|static[]
     * 发送人
     */
    public function sender(){
        return $this->hasOne(User::class,'id','user_id');

    }

    public function senderinfo(){
        return $this->hasOne(User::class,'id','user_id')->with('getinfo');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 消息中的附件表
     */
    public function enclosures(){
        return $this->hasMany(Enclosure::class,'id','enclosure_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 回复
     */
    public function replies(){
        return $this->hasMany(MessageType::class,'id','message_id');
    }

}
