<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProvinceModel extends Model
{
    protected $table    = 'refprovince';
    public $timestamps  = false;
    public $primaryKey  = 'id';
}
