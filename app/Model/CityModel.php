<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
   	protected $table    = 'refcitymun';
    public $timestamps  = false;
    public $primaryKey  = 'id';
}
