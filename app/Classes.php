<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use SoftDeletes;
    protected $fillable=['name','type', 'user_id', 'number', 'password','verification','user_allow'];
    protected $table='classes';
}
