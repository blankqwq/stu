<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;
    protected $table='files';
    protected $fillable=['name','path','url','type','file_size','pid'];

    public function filetable()
    {
        return $this->morphTo();
    }
}
