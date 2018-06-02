<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enclosure extends Model
{
    protected $table='enclosures';
    protected $fillable=['url','size','name'];
    //
}
