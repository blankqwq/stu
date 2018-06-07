<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use SoftDeletes;
    protected $fillable=['avatar','name','type', 'user_id', 'number', 'password','verification','user_allow'];
    protected $table='classes';

    /**
     * 查询班级类型
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function types(){
        return $this->belongsToMany(ClassType::class,'class_t','class_id','type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * 获取班级boss
     */
    public function boss(){
        return $this->hasOne(User::class,'id','user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 获取用户
     */
    public function users(){
        return $this->belongsToMany(User::class,'user_classes','class_id','user_id')->wherePivot('token', null);;
    }

    public function messages(){
        return $this->morphMany(Message::class,'messagetable');
    }

    public function getallusers(){
        return $this->belongsToMany(User::class,'user_classes','class_id','user_id')->with('getinfo');
    }

    public function homeworks(){
        return $this->hasMany(Homework::class,'class_id','id');
    }

    public function files(){
        return $this->morphMany(File::class,'filetable');
    }

}
