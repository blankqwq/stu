<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassType extends Model
{
    use SoftDeletes;
    protected $table='class_type';
    protected $fillable=['category',''];

    public function classes(){
        return $this->belongsToMany(Classes::class,'class_t','type_id','class_id');
    }
}
