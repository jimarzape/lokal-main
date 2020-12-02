<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BarangayModel extends Model
{
    protected $table    = 'refbrgy';
    public $timestamps  = false;
    public $primaryKey  = 'id';
}
