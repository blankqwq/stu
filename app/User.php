<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait { EntrustUserTrait::restore as private restoreA; }
    use SoftDeletes { SoftDeletes::restore as private restoreB; }
    use EntrustUserTrait;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * 解决 EntrustUserTrait 和 SoftDeletes 冲突
     */
    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 获取对应的班级
     */
    public function classes(){
        return $this->belongsToMany(Classes::class,'user_classes','user_id','class_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getinfo(){
        return $this->hasOne(UserInfo::class,'user_id','id');
    }
}
