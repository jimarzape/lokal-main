<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeliveryStatus extends Model
{
    protected $table    = 'delivery_status';
    public $timestamps  = false;
    public $primaryKey  = 'id';
}
