<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use SoftDeletes;
    protected $fillable=['name','type', 'user_id', 'number', 'password','verification','user_allow'];
    protected $table='classes';

    /**
     * 查询班级类型
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function types(){
        return $this->hasMany(ClassType::class,'class_id','id');
    }
}
